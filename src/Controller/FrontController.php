<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Dossier;
use App\Form\ContactType;
use App\Form\DossierDefendeurFromType;
use App\Form\DossierFrontType;
use App\Form\DossierRequerantType;
use App\Repository\ArrondissementRepository;
use App\Repository\DossierRepository;
use App\Repository\PartieRepository;
use App\Repository\RepresentantRepository;
use App\Service\CodeGenerator;
use App\Service\FileUploader;
use App\Service\MailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FrontController extends AbstractController
{
    #[Route(path: '/', name: 'app_index_front', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('front/index.html.twig');
    }

    #[Route(path: 'depot-recours/mes-informations', name: 'front_requerant')]
    public function etapeRequerant(
        SessionInterface $session,
        Request $request,
        DossierRepository $dossierRepository,
        ArrondissementRepository $arrondissementRepository,
        RepresentantRepository $representantRepository,
        PartieRepository $requerantRepository
    ): Response {
        $dossier = new Dossier();
        $form = $this->createForm(DossierRequerantType::class, $dossier, [
            'action' => $this->generateUrl('front_requerant'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $localite_requerant_id = $request->request->get('localite_requerent');
            $localite_requerant = $arrondissementRepository->find($localite_requerant_id);
            $dossier->getRequerant()->setLocalite($localite_requerant);
            $dossier->getRequerant()->setStatus('REQUERANT');

            $type = $form->get('requerant')->get('type')->getData();
            if ($type == 'moral') {
                if ($form->get('requerant')->get('representants1')) {
                    $data_represantant = $form->get('requerant')->get('representants1')->getData();
                    if ($data_represantant) {
                        $data_represantant->setPartie($dossier->getRequerant());
                        $representantRepository->add($data_represantant, true);
                    }
                }
            }
            $dossierRepository->add($dossier, true);
            $session->set('_dossier', $dossier->getId());
            return $this->redirectToRoute('defendeur', [], Response::HTTP_SEE_OTHER);
        }

        if ($request->isXmlHttpRequest()) {
            return $this->render('meetup/_subform.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('front/recours/requerant.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route(path: 'depot-recours/infos-defendeur', name: 'defendeur')]
    public function etapeDefendeur(SessionInterface $session, Request $request, DossierRepository $dossierRepository): Response
    {
        $dossier_id = $session->get('_dossier');

        if (!$dossier_id) {
            return $this->redirectToRoute('front_requerant');
        }

        $dossier = $dossierRepository->find($dossier_id);
        if (!$dossier) {
            return $this->redirectToRoute('front_requerant');
        }

        $form = $this->createForm(DossierDefendeurFromType::class, $dossier, [
            'action' => $this->generateUrl('defendeur'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->getDefendeur()->setStatus('DEFENDEUR');
            $dossierRepository->add($dossier, true);
            return $this->redirectToRoute('front_recours', [], Response::HTTP_SEE_OTHER);
        }

        if ($request->isXmlHttpRequest()) {
            return $this->render('meetup/_subform.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('front/recours/defendeur.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route(path: 'depot-recours/details-du-recours', name: 'front_recours')]
    public function etapeDossier(
        SessionInterface $session,
        Request $request,
        DossierRepository $dossierRepository,
        FileUploader $fileUploader,
        CodeGenerator $codeGenerator,
        MailService $mailService
    ): Response {
        $dossier_id = $session->get('_dossier');

        if (!$dossier_id) {
            return $this->redirectToRoute('defendeur');
        }

        $dossier = $dossierRepository->find($dossier_id);
        if (!$dossier) {
            return $this->redirectToRoute('defendeur');
        }

        $form = $this->createForm(DossierFrontType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('pieces')) {
                foreach ($form->get('pieces')->all() as $pieceitem) {
                    $piece = $pieceitem->getData();
                    $image = $pieceitem->get('document')->getData();
                    $fichier = $fileUploader->upload($image, null, 'piecesJointes');
                    $piece->setUrl($fichier);
                    $piece->setDossier($dossier);
                }
            }

            do {
                $codeSuivi = $codeGenerator->Generator();
                $existingCode = $dossierRepository->findOneBy(['codeSuivi' => $codeSuivi]);
            } while ($existingCode !== null);

            $dossier->setCodeSuivi($codeSuivi);
            $dossier->setCreatedBy(null);
            $dossier->setEtatDossier('NOUVEAU');
            $dossier->setExterne(true);
            $dossier->setDateEnregistrement(new \DateTime());
            $dossierRepository->add($dossier, true);

            if ($dossier->getRequerant()->getEmail()) {
                $mail = $dossier->getRequerant()->getEmail();
                $sujet = 'Votre recours a été bien enregistré';
                $context = [
                    'requerent' => $dossier->getRequerant()->getPrenoms() . ' ' . $dossier->getRequerant()->getNom(),
                    'codeSuivi' => $codeSuivi,
                    'lien' => $this->generateUrl('front_recours_status', [], UrlGeneratorInterface::ABSOLUTE_URL),
                ];
                $mailService->sendEmail($mail, $sujet, 'resume.html.twig', $context);
            }

            $sujet = 'Recours déposé sur la plateforme';
            $mail = 'juridiction@coursupreme.bj';
            $context = [
                'requerent' => $dossier->getRequerant()->getPrenoms() . ' ' . $dossier->getRequerant()->getNom(),
                'lien' => $this->generateUrl('app_login', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ];
            $mailService->sendEmail($mail, $sujet, 'notifications.html.twig', $context);

            return $this->redirectToRoute('front_recapt', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/recours/dossier.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route(path: 'depot-recours/recap', name: 'front_recapt')]
    public function recaputilatif(SessionInterface $session, DossierRepository $dossierRepository): Response
    {
        $dossier_id = $session->get('_dossier');

        if (!$dossier_id) {
            return $this->redirectToRoute('app_index_front');
        }

        $dossier = $dossierRepository->find($dossier_id);
        if ($dossier) {
            $session->remove('_dossier');
        }

        return $this->render('front/recours/resume.html.twig', [
            'dossier' => $dossier,
        ]);
    }

    #[Route(path: 'depot-recours/status', name: 'front_recours_status')]
    public function verifierStatus(Request $request, DossierRepository $dossierRepository): Response
    {
        $form = $this->createFormBuilder()
            ->add('identifiant', TextType::class, [
                'label' => 'Saisissez votre code de suivi ou la référence du dossier',
                'attr' => [
                    'placeholder' => 'Entrez votre code de suivi ou référence de dossier',
                ],
            ])
            ->getForm();

        $form->handleRequest($request);
        $dossier = null;
        $statut = '';

        if ($form->isSubmitted() && $form->isValid()) {
            $identifiant = $form->get('identifiant')->getData();
            
            $dossier = $dossierRepository->createQueryBuilder('d')
                ->where('d.externe = true AND (d.codeSuivi = :identifiant OR d.referenceDossier = :identifiant)')
                ->setParameter('identifiant', $identifiant)
                ->getQuery()
                ->getOneOrNullResult();

            if ($dossier) {
                $statut = $dossier->getStatut();
            } else {
                $statut = "Aucun dossier trouvé avec cet identifiant";
            }
        }

        return $this->render('front/status/verification_status.html.twig', [
            'form' => $form->createView(),
            'status' => $statut,
            'dossier' => $dossier,
        ]);
    }

    #[Route(path: '/nous-contacter', name: 'app_contacter')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactData = $form->getData();
            $userCaptchaAnswer = $form->get('captcha')->getData();
            $correctCaptchaAnswer = $form->get('captcha_result')->getData();

            if ((int) $userCaptchaAnswer !== (int) $correctCaptchaAnswer) {
                $this->addFlash('danger', 'Le CAPTCHA est incorrect. Veuillez réessayer.');
                return $this->redirectToRoute('app_contacter');
            }

            $email = (new Email())
                ->from($contactData['email'])
                ->to('juridiction@coursupreme.bj')
                ->subject($contactData['subject'])
                ->text($contactData['message'])
                ->html('
                    <p> Ceci est un message envoyé par un requérant depuis la plateforme earret. </p>
                    <p>Ses identifiants sont : </p>
                    <ul>
                        <li><strong>Nom :</strong> ' . $contactData['name'] . '</li>
                        <li><strong>Mail :</strong> ' . $contactData['email'] . '</li>
                    </ul>
                    <p><strong>Son Message est :</strong></p>
                    <p>' . nl2br($contactData['message']) . '</p>
                ');

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            return $this->redirectToRoute('app_contacter');
        }

        return $this->render('front/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}