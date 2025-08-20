<?php

namespace App\Controller;

use App\Entity\AffecterSection;
use App\Entity\AffecterStructure;
use App\Entity\AffecterUser;
use App\Entity\Dossier;
use App\Entity\User;
use App\Entity\UserDossier;
use App\Form\AffecterSectionType;
use App\Form\AffecterStructurePGType;
use App\Form\AffecterStructureType;
use App\Form\AffecterUserCRType;
use App\Form\AffecterUserType;
use App\Form\AutorisationOuvertureType;
use App\Form\OuvertureAffecterSectionType;
use App\Form\UserDossierType;
use App\Repository\AffecterSectionRepository;
use App\Repository\AffecterStructureRepository;
use App\Repository\AffecterUserRepository;
use App\Repository\DossierRepository;
use App\Repository\StructureRepository;
use App\Repository\UserDossierRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/president-chambre/dossiers')]
//#[IsGranted('ROLE_PCJ')]
#[IsGranted(new Expression('is_granted("ROLE_PCA") or is_granted("ROLE_PCJ") or is_granted("ROLE_PCS")'))]
class PresidentChambreController extends AbstractController
{
    #[Route(path: '/liste-recours', name: 'app_president_chambre')]
    public function index(DossierRepository $dossierRepository): Response
    {

        $structure = $this->getUser()->getStructure();
        // dd($this->getUser()->getStructure()->getId());
        //$this->g
        return $this->render('president/recours.html.twig', [
            'dossiers' => $dossierRepository->findBy([
                'etatDossier' => 'RECOURS',
                'structure' => $structure->getId()
//                'createdBy'=>$this->getUser(),
//                'structure'=>$this->getUser()->getStructure()
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
            'form' => $form,
            'greffierEnChef' => $greffierEnChef,
            'dossier' => $dossier,
        ]);
    }

    #[Route(path: '/affectation-dossier/{id}', name: 'autorisation_affectation_dossier', methods: ['GET', 'POST'])]
    public function affectionDossierCRGR(Request $request, AffecterSectionRepository $affecterSectionRepository, Dossier $dossier, UserDossierRepository $userDossierRepository, UserRepository $userRepository): Response
    {
        $affecterSection = new AffecterSection();
        $affecterSection->setDossier($dossier);
        $structure = $this->getUser()->getStructure();
//        dd($structure);
        $form = $this->createForm(OuvertureAffecterSectionType::class, $affecterSection, ['structure' => $structure]);
        //   dd($request->);
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
            $this->addFlash('success', 'L\'autorisation d\'ouverture du recours à été effectuée avec success et affecte à : ' . $form->get('section')->getData()->getName());

            return $this->redirectToRoute('app_recours_autorisation');
        }

        return $this->render('president/affectation_ouverture.html.twig', [
            'affecter_section' => $affecterSection,
            'form' => $form,
            'dossier' => $dossier,
        ]);
    }

    #[Route(path: '/liste-recours-autorisation', name: 'app_recours_autorisation')]
    public function listeRecoursAutorise(DossierRepository $dossierRepository): Response
    {
        $structure = $this->getUser()->getStructure();
        return $this->render('president/liste-autorisation.html.twig', [
            'dossiers' => $dossierRepository->findBy([
                'etatDossier' => 'AUTORISATION',
//                'createdBy'=>$this->getUser(),
                'structure' => $this->getUser()->getStructure()
            ]),
        ]);
    }

    #[Route(path: '/dossiers-ouverts', name: 'pc_dossier_ouverture', methods: ['GET', 'POST'])]
    public function ListeAffectations(DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
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
    public function affectationsPG(#[CurrentUser] User $user, DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
    {

        return $this->render('president/liste_affectation_PG.html.twig', [
            'dossiers' => $dossierRepository->findBy(['statut' => 'Dossier au Rôle']),
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
//            'affecter_structure' => $affecterStructure,
            'dossier' => $dossier,
            'form' => $form,
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
            'profil' =>'CONSEILLER RAPPORTEUR'
        ]);
        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->setEtatDossier('AVIS CR');
            $affecterUser->setExpediteur($this->getUser());
           // $affecterUser->setDestinataire($destinataire);
            $affecterUser->setDestinataire($destinataire->getUser());
            $affecterUserRepository->add($affecterUser, true);
//            $this->addFlash('success', 'le dossier a été bien transferé au conseilleur rapporteur : ' . $form->get('destinataire')->getData()->getUserInformations() . ' pour ouverture');
            return $this->redirectToRoute('admin_dossier_affections', ['id' => $dossier->getId()]);
        }

        return $this->render('president/affectation_conseiller_rapporteut.html.twig', [
//            'affecter_structure' => $affecterStructure,
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

}
