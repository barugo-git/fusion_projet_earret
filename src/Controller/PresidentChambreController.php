<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\User;
use App\Entity\Dossier;
use App\Entity\Structure;
use App\Entity\UserDossier;
use App\Entity\AffecterUser;
use App\Form\UserDossierType;
use App\Form\AffecterUserType;
use App\Entity\AffecterSection;
use App\Form\AffecterUserCRType;
use App\Entity\AffecterStructure;
use App\Form\AffecterSectionType;
use App\Repository\UserRepository;
use App\Form\AffecterStructureType;
use Symfony\Component\Mime\Address;
use App\Form\AffecterStructurePGType;
use App\Repository\DossierRepository;
use App\Repository\SectionRepository;
use App\Form\AutorisationOuvertureType;
use App\Repository\StructureRepository;
use App\Repository\UserDossierRepository;
use App\Form\OuvertureAffecterSectionType;
use App\Repository\AffecterUserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Repository\AffecterSectionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AffecterStructureRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/president-chambre/dossiers')]
#[IsGranted(new Expression('is_granted("ROLE_PCA") or is_granted("ROLE_PCJ") or is_granted("ROLE_PCS")'))]
class PresidentChambreController extends AbstractController
{
    #[Route(path: '/liste-recours', name: 'app_president_chambre')]
    public function index(DossierRepository $dossierRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('User object is not an instance of App\Entity\User.');
        }
        $structure = $user->getStructure();

        return $this->render('president/recours.html.twig', [
            'dossiers' => $dossierRepository->findBy([
                'etatDossier' => 'RECOURS',
                'structure' => $structure->getId()
            ]),
        ]);
    }

    #[Route(path: '/autorisation-dossier/{id}', name: 'autorisation_ouverture_dossier', methods: ['GET', 'POST'])]
    public function autorisationOvertureDossier(Request $request, Dossier $dossier, DossierRepository $dossierRepository, UserRepository $userRepository): Response
    {
        $form = $this->createForm(AutorisationOuvertureType::class, $dossier);
        $form->handleRequest($request);
        $greffierEnChef = $userRepository->findOneBy(['titre' => 'GREFFIER EN CHEF'])->getFullName();

        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->setEtatDossier("AUTORISATION");
            $dossier->setAutorisation(true);
            $dossierRepository->add($dossier, true);
            $this->addFlash('success', 'L\'autorisation d\'ouverture du recours a été effectuée avec success');

            return $this->redirectToRoute('app_recours_autorisation');
        }

        return $this->render('president/autorisation_ouverture.html.twig', [
            'form' => $form->createView(),
            'greffierEnChef' => $greffierEnChef,
            'dossier' => $dossier,
        ]);
    }

    #[Route(path: '/affectation-dossier/{id}', name: 'autorisation_affectation_dossier', methods: ['GET', 'POST'])]
    public function affectionDossierCRGR(
        Request $request,
        AffecterSectionRepository $affecterSectionRepository,
        Dossier $dossier,
        UserDossierRepository $userDossierRepository,
        MailerInterface $mailer,
        UserRepository $userRepository,
        StructureRepository $structureRepository,
        SectionRepository $sectionRepository
    ): Response {


        $affecterSection = new AffecterSection();
        $affecterSection->setDossier($dossier);
        
        $structure = $this->getUser()->getStructure();

        $form = $this->createForm(OuvertureAffecterSectionType::class, $affecterSection, ['structure' => $structure]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $conseiller = new UserDossier();
            $greffier = new UserDossier();

            $conseiller->setDossier($dossier);
            $conseiller->setUser($form->get('conseillerRapporteur')->getData());
            $conseiller->setProfil("CONSEILLER RAPPORTEUR");

            $greffier->setDossier($dossier);
            $greffier->setUser($form->get('greffier')->getData());
            $greffier->setProfil("GREFFIER");

            $userDossierRepository->add($conseiller);
            $userDossierRepository->add($greffier);
            $dossier->setAutorisation(true);
            $affecterSectionRepository->add($affecterSection, true);
            $this->addFlash('success', 'L\'autorisation d\'ouverture du recours à été effectuée avec success et affectée à : ' . $form->get('section')->getData()->getName());
            // --- 1. Envoi aux rapporteurs (UserDossiers) ---
            $structures = $structureRepository->findAll();
            $sections = $sectionRepository->findAll();



            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);

            $dompdf = new Dompdf($options);
            $html = $this->renderView('pdfs/ajout_membre_pdf.html.twig', [
                'dossier' => $dossier,
                'affecterSections' => $affecterSection,
                'userDossiers' => $dossier->getUserDossiers(),
            ]);

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Récupérer le PDF en mémoire
            $pdfOutput = $dompdf->output();
            foreach ($dossier->getUserDossiers() as $userDossier) {
                $this->sendMailToRapporteur($userDossier, $dossier, $mailer, $structures, $sections, $pdfOutput);
            }


            return $this->redirectToRoute('app_recours_autorisation');
        }

        return $this->render('president/affectation_ouverture.html.twig', [
            'affecter_section' => $affecterSection,
            'form' => $form->createView(),
            'dossier' => $dossier,
        ]);
    }

    #[Route(path: '/liste-recours-autorisation', name: 'app_recours_autorisation')]
    public function listeRecoursAutorise(DossierRepository $dossierRepository): Response
    {
        return $this->render('president/liste-autorisation.html.twig', [
            'dossiers' => $dossierRepository->findBy([
                'etatDossier' => 'AUTORISATION',
                'structure' => $this->getUser()->getStructure()
            ]),
        ]);
    }

    #[Route(path: '/dossiers-ouverts', name: 'pc_dossier_ouverture', methods: ['GET', 'POST'])]
    public function ListeAffectations(DossierRepository $dossierRepository): Response
    {
        $structure = $this->getUser()->getStructure();
        return $this->render('dossier/dossier_ouvert_pc.html.twig', [
            'dossiers' => $dossierRepository->findBy([
                'etatDossier' => 'OUVERT',
                'structure' => $structure->getId()
            ]),
        ]);
    }

    #[Route(path: '/conclusions-parquets', name: 'pc_conclusion_parquet', methods: ['GET', 'POST'])]
    public function conclusionDuParquet(DossierRepository $dossierRepository): Response
    {
        $structure = $this->getUser()->getStructure();
        return $this->render('president/conclusion_parquet.html.twig', [
            'dossiers' => $dossierRepository->findBy([
                'etatDossier' => 'CONCLUSION DISPONIBLE',
                'structure' => $structure->getId()
            ]),
        ]);
    }

    #[Route(path: '/affectations-au-parquet/', name: 'pc_dossier_affectations_list')]
    public function affectationsPG(#[CurrentUser] User $user, DossierRepository $dossierRepository): Response
    {
        return $this->render('president/liste_affectation_PG.html.twig', [
            'dossiers' => $dossierRepository->findBy(['statut' => 'Dossier audiencé']),
        ]);
    }

    #[Route(path: '/affectation-au-parquet/dossier/{id}', name: 'pc_affecter_dossier_au_pg', methods: ['GET', 'POST'])]
    public function affectionStructureDossier(#[CurrentUser] User $user, Request $request, AffecterStructureRepository $affecterStructureRepository, Dossier $dossier, StructureRepository $structureRepository): Response
    {
        $affecterStructure = new AffecterStructure();
        $affecterStructure->setDossier($dossier);
        $form = $this->createForm(AffecterStructurePGType::class, $affecterStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pg = $structureRepository->findOneBy([
                'codeStructure' => 'PG'
            ]);
            $affecterStructure->setStructure($pg);
            $affecterStructure->setDe($this->getUser()->getStructure());
            $affecterStructureRepository->add($affecterStructure, true);
            $this->addFlash('success', 'le dossier a été bien affecté au parquet');

            return $this->redirectToRoute('pc_dossier_affectations_list');
        }

        return $this->render('president/affectationPCauPG.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/transfert-dossier-au-conseiller-rapporteur/{id}', name: 'pc_transfert_rapporteur', methods: ['GET', 'POST'])]
    public function affectionUser(Request $request, UserDossierRepository $userDossierRepository, AffecterUserRepository $affecterUserRepository, Dossier $dossier): Response
    {
        $affecterUser = new AffecterUser();
        $affecterUser->setDossier($dossier);
        $form = $this->createForm(AffecterUserCRType::class, $affecterUser);
        $form->handleRequest($request);
        $destinataire = $userDossierRepository->findOneBy([
            'dossier' => $dossier,
            'profil' => 'CONSEILLER RAPPORTEUR'
        ]);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->setEtatDossier('AVIS CR');
            $affecterUser->setExpediteur($this->getUser());
            $affecterUser->setDestinataire($destinataire->getUser());
            $affecterUserRepository->add($affecterUser, true);

            $this->addFlash('success', 'Le dossier a été bien transféré au conseiller rapporteur.');
            return $this->redirectToRoute('admin_dossier_affections', ['id' => $dossier->getId()]);
        }

        return $this->render('president/affectation_conseiller_rapporteut.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    private function sendMailToRapporteur($userDossier, $dossier, $mailer, $structures, $sections, $pdfOutput)
    {
        $userEmail = $userDossier->getUser()->getUserIdentifier(); // ex: "user@example.com"

        $email = (new TemplatedEmail())
            ->from(new Address('juridiction@coursupreme.bj', 'Cour Suprême'))
            ->to(new Address($userEmail)) // destinataire
            ->subject('Alerte affectation d\'un nouveau dossier')
            ->htmlTemplate('mailer/ajout_membre.html.twig')
            ->context([
                'destinataire' => $userDossier->getUser()->getUserInformations(),
                'profile' => $userDossier->getProfil(),
                'dossier' => $dossier,
                'structure' => $structures,
                'section' => $sections,
                'lien_login' => $this->generateUrl('app_login', [], UrlGeneratorInterface::ABSOLUTE_URL)
            ])
            ->attach($pdfOutput, 'AffectationDossier.pdf', 'application/pdf'); // PJ

        // 3️⃣ Envoi
        $mailer->send($email);
    }
}
