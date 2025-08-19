<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Dossier;
use App\Form\ContactType;
use App\Form\DossierDefendeurFromType;
use App\Form\DossierDefendeurType;
use App\Form\DossierFrontType;
use App\Form\DossierRequerantType;
use App\Form\DossierType;
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

//#[Route(path: '/depot-recours')]
class FrontController extends AbstractController
{

    #[Route(path: '/', name: 'app_index_front', methods: ['GET'])]
    public function index(): Response
    {
     return $this->render('front/index.html.twig');
      //  return $this->render('front/front_base.html.twig');
    }

    #[Route(path: 'depot-recours/mes-informations', name: 'front_requerant')]
    public function etapeRequerant(SessionInterface $session, Request $request, DossierRepository $dossierRepository, ArrondissementRepository $arrondissementRepository, RepresentantRepository $representantRepository
        , PartieRepository                          $requerantRepository)
    {

        $dossier = new Dossier();

        $form = $this->createForm(DossierRequerantType::class, $dossier, ['action' => $this->generateUrl('front_requerant')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            $requerant_telephone = $form->get('requerant')->get('Telephone')->getData();
//            $requerant_exist = $requerantRepository->findOneBy(['Telephone' => $requerant_telephone, 'status' => 'REQUERANT']);
//
//            if ($requerant_exist) {
//                $dossier->setRequerant($requerant_exist);
//            } else {
//                $localite_requerant_id = $request->request->get("localite_requerent");
//                $localite_requerant = $arrondissementRepository->find($localite_requerant_id);
//                $dossier->getRequerant()->setLocalite($localite_requerant);
//            }

//            $this->addFlash('success', 'La réquete a été enregistrée avec success');
            $localite_requerant_id = $request->request->get("localite_requerent");
            $localite_requerant = $arrondissementRepository->find($localite_requerant_id);
            $dossier->getRequerant()->setLocalite($localite_requerant);
            $dossier->getRequerant()->setStatus('REQUERANT');

            $type = $form->get('requerant')->get('type')->getData();
            if ($type == 'moral') {
                if ($form->get('requerant')->get('representants1')) {

                    $data_represantant = $form->get('requerant')->get('representants1')->getData();

//                dd( $data_represantant['nom']);
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

        // Handle AJAX request
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
    public function etapeDefendeur(SessionInterface $session, Request $request, DossierRepository $dossierRepository)
    {
        $dossier_id = $session->get('_dossier');
//        dd($dossier_id);
        if ($dossier_id) {
            $dossier = $dossierRepository->find($dossier_id);

            $form = $this->createForm(DossierDefendeurFromType::class, $dossier, ['action' => $this->generateUrl('defendeur')]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $dossier->getDefendeur()->setStatus('DEFENDEUR');

                $dossierRepository->add($dossier, true);
                //  $session->set('_dossier', $dossier->getId());
                return $this->redirectToRoute('front_recours', [], Response::HTTP_SEE_OTHER);

            }

            if ($request->isXmlHttpRequest()) {
                return $this->render('meetup/_subform.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

        } else {
            return $this->redirectToRoute('front_requerant');
        }
        return $this->render('front/recours/defendeur.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route(path: 'depot-recours/details-du-recours', name: 'front_recours')]
    public function etapeDossier(SessionInterface $session, Request $request, DossierRepository $dossierRepository, FileUploader $fileUploader, CodeGenerator $codeGenerator, MailService $mailService
    )
    {
        $dossier_id = $session->get('_dossier');
        //  dd( $dossier_id );
        if ($dossier_id) {

            $dossier = $dossierRepository->find($dossier_id);
            $form = $this->createForm(DossierFrontType::class, $dossier);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

//                dd($form->get('pieces')->all());
                if($form->get('pieces')){
                    foreach ($form->get('pieces')->all() as $pieceitem) {
                        $piece = $pieceitem->getData();
                        $image = $pieceitem->get('document')->getData();
                        ///   $fmane = $form->get('referenceEnregistrement')->getData();
                        $fichier = $fileUploader->upload($image, null, 'piecesJointes');
                        $piece->setUrl($fichier);
                        $piece->setDossier($dossier);
                    }
                }

                do {
                    // Générer un code aléatoire
                    $codeSuivi = $codeGenerator->Generator();

                    // Vérifier si le code existe déjà dans la base de données
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

                    $context =[
                      'requerent'=>$dossier->getRequerant()->getPrenoms().' '.$dossier->getRequerant()->getNom(),
                      'codeSuivi'=> $codeSuivi,
                       'lien'=>$this->generateUrl('front_recours_status',[], UrlGeneratorInterface::ABSOLUTE_URL),
                 ];

                    $mailService->sendEmail($mail,$sujet,'resume.html.twig',$context);


                    $sujet = 'Votre recours a été bien enregistré';

                    $context =[
                        'requerent'=>$dossier->getRequerant()->getPrenoms().' '.$dossier->getRequerant()->getNom(),
                        'codeSuivi'=> $codeSuivi,
                         'lien'=>$this->generateUrl('front_recours_status',[], UrlGeneratorInterface::ABSOLUTE_URL),

                    ];

                //    $mailService->sendEmail($mail,$sujet,'resume.html.twig',$context);

                }

                $sujet = 'Recours déposé sur la plateforme';
                $mail = ' juridiction@coursupreme.bj';
                $context =[
                    'requerent'=>$dossier->getRequerant()->getPrenoms().' '.$dossier->getRequerant()->getNom(),
                    'lien'=>$this->generateUrl('app_login',[], UrlGeneratorInterface::ABSOLUTE_URL),

                ];

                $mailService->sendEmail($mail,$sujet,'notifications.html.twig',$context);
                return $this->redirectToRoute('front_recapt', [], Response::HTTP_SEE_OTHER);

            }

        } else {
            return $this->redirectToRoute('defendeur');
        }
        return $this->render('front/recours/dossier.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route(path: 'depot-recours/recap', name: 'front_recapt')]
    public function recaputilatif(SessionInterface $session, Request $request, DossierRepository $dossierRepository)
    {
        $dossier_id = $session->get('_dossier');

        if ($dossier_id) {

            $dossier = $dossierRepository->find($dossier_id);
            $session->remove('_dossier');
        } else {
            return $this->redirectToRoute('app_index_front');
        }
//        dd( $dossier );
        return $this->render('front/recours/resume.html.twig', [
            'dossier' => $dossier,
//            'form' => $form,
        ]);
    }

    #[Route(path: 'depot-recours/status', name: 'front_recours_status')]
    public function verifierStatus(Request $request, DossierRepository $dossierRepository)
    {
        $form = $this->createFormBuilder()
            ->add('identifiant', TextType::class, [
                'label' => 'Saisissez votre code de suivi ou la référence du dossier',
                'attr' => [
                    'placeholder' => 'Entrez votre code de suivi ou référence de dossier'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $identifiant = $form->get('identifiant')->getData();
            
            // Recherche d'abord par codeSuivi, puis par referenceDossier
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

            return $this->render('front/status/verification_status.html.twig', [
                'form' => $form->createView(),
                'status' => $statut,
                'dossier' => $dossier
            ]);
        }

        return $this->render('front/status/verification_status.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route(path: '/nous-contacter', name: 'app_contacter')]
    public function contact(Request $request,MailerInterface $mailer):Response

    {
        $form = $this->createForm(ContactType::class);

        // Traitement du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $contactData = $form->getData();
            $userCaptchaAnswer = $form->get('captcha')->getData();
            $correctCaptchaAnswer = $form->get('captcha_result')->getData();

            // Validation du CAPTCHA
            if ((int)$userCaptchaAnswer !== (int)$correctCaptchaAnswer) {
                $this->addFlash('danger', 'Le CAPTCHA est incorrect. Veuillez réessayer.');
                return $this->redirectToRoute('app_contacter');
            }
            // Envoyer l'e-mail si CAPTCHA valide

            $email = (new Email())
                ->from($contactData['email'])
                ->to('juridiction@coursupreme.bj')  // Mettre l'adresse du destinataire ici
                // ->replyTo($contactData['email'])
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

            // Ajouter un message flash de succès
            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            // Rediriger après l'envoi pour éviter la soumission multiple
            return $this->redirectToRoute('app_contacter');
        }

        // Afficher le formulaire
        return $this->render('front/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }

}
