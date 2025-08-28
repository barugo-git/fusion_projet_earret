<?php

namespace App\Controller;

use App\Entity\Dossier;
use App\Entity\UserDossier;
use App\Form\UserDossierType;
use App\Form\DossierSpecialType;
use App\Entity\AffecterStructure;
use App\Form\AffectationUserType;
use App\Form\AffecterStructureType;
use App\Repository\PartieRepository;
use App\Repository\DossierRepository;
use App\Repository\DefendeurRepository;
use App\Repository\UserDossierRepository;
use App\Repository\ArrondissementRepository;
use App\Repository\AffecterSectionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AffecterStructureRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/greffier-en-chef')]
#[IsGranted('ROLE_GREFFIER_EN_CHEF')]
class GreffierChefController extends AbstractController
{
    #[Route(path: '/', name: 'greffier_chef_recours')]
    public function index(DossierRepository $dossierRepository): Response
    {
        $listRecours = $dossierRepository->findBy([
            'autorisation'=>true,
            'etatDossier'=>'AUTORISATION'
        ]);
        return $this->render('greffe/liste-autorisation-greffe-chef.html.twig',
            [
                'dossiers' => $listRecours,
            ]);
    }

    #[Route(path: '/affecter-un-greffe/{id}', name: 'greffier_chef_affectations_greffe')]
    public function affecteUnGreffe(Request $request, Dossier $dossier, UserDossierRepository $userDossierRepository, DossierRepository $dossierRepository)
    {
        $affectation = new UserDossier();
        $form = $this->createForm(AffectationUserType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->setEtatDossier("AFFECTE");
            $dossierRepository->add($dossier);

            $affectation->setDossier($dossier);
            $affectation->setProfil('GREFFE');
            $affectation->setNature('AFFECTATION');
            $userDossierRepository->add($affectation, true);

            $this->addFlash('success', 'le recours a été bien affecté au greffier');
            return $this->redirectToRoute('greffier_chef_affectations_greffe_list');
        }

        return $this->render('greffe/new_affectation_greffe.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/liste-affectation-greffier', name: 'greffier_chef_affectations_greffe_list')]
    public function listeAfectationGreffier(DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
    {
        $listeAffectation = $dossierRepository->listeGreffierRecours();
        return $this->render('greffe/liste-greffe-recours.html.twig',
            [
                'dossiers' => $listeAffectation,
            ]);
    }

    #[Route(path: '/liste-dossier-ouvert', name: 'greffier_chef_dossier_affectations_list')]
    public function ListeAffectations(DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
    {

        return $this->render('dossier/index_affectation.html.twig', [
            'dossiers' => $dossierRepository->findBy(['etatDossier' => 'OUVERT']),
        ]);
    }
    #[Route(path: '/affectation/structure/{id}', name: 'greffier_chef_affectation_structure_new', methods: ['GET', 'POST'])]
    public function affectionStructureDossier(Request $request, AffecterStructureRepository $affecterStructureRepository, Dossier $dossier): Response
    {
        $affecterStructure = new AffecterStructure();
        $affecterStructure->setDossier($dossier);
        $form = $this->createForm(AffecterStructureType::class, $affecterStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affecterStructure->setDe($this->getUser()->getStructure());
            $affecterStructureRepository->add($affecterStructure, true);
            $this->addFlash('success', 'le dossier a été bien affecté à la structure : ' . $form->get('structure')->getData()->getName());

            return $this->redirectToRoute('admin_dossier_affections', ['id' => $dossier->getId()]);
        }

        return $this->render('affecter_structure/new.html.twig', [
//            'affecter_structure' => $affecterStructure,
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route(path: '/requete-speciale', name: 'greffier_chef__requete_speciale_new')]
    public function new(Request $request, DossierRepository $dossierRepository, ArrondissementRepository $arrondissementRepository, DefendeurRepository $defendeurRepository
        , PartieRepository $requerantRepository): Response
    {
        $dossier = new Dossier();
        $form = $this->createForm(DossierSpecialType::class, $dossier);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

//            dd($request->request->get("city"));
            // dd($arrondissementRepository->find($request->request->get("localite_requerent")),$arrondissementRepository->find($request->request->get("localite_defendeur")));
            // Recuperation des id de la locallite du requerent et du defendeur
//            $localite_requerant_id= $request->request->get("localite_requerent");
//            $localite_defendeur_id=$request->request->get("localite_defendeur");
//            $localite_requerant= $arrondissementRepository->find( $localite_requerant_id);
//            $localite_defendeur=  $arrondissementRepository->find($localite_defendeur_id);
//            $dossier->getRequerant()->setLocalite( $localite_requerant);
//            $dossier->getDefendeur()->setLocalite( $localite_defendeur);

            $requerant_telephone = $form->get('requerant')->get('Telephone')->getData();
            $defendeur_telephone = $form->get('defendeur')->get('telephone')->getData();
//            $defendeur_telephone = $form->get('defendeur')->get('telephone')->getData();
            $requerant_exist = $requerantRepository->findOneBy(['Telephone' => $requerant_telephone]);
            $defendeur_exist = $defendeurRepository->findOneBy(['telephone' => $defendeur_telephone]);

            if ($requerant_exist) {
                $dossier->setRequerant($requerant_exist);
            } else {
                $localite_requerant_id = $request->request->get("localite_requerent");
                $localite_requerant = $arrondissementRepository->find($localite_requerant_id);
                $dossier->getRequerant()->setLocalite($localite_requerant);
            }


            if ($defendeur_exist) {
                $dossier->setDefendeur($defendeur_exist);
            } else {
                $localite_defendeur_id = $request->request->get("localite_defendeur");
                $localite_defendeur = $arrondissementRepository->find($localite_defendeur_id);
                $dossier->getDefendeur()->setLocalite($localite_defendeur);

            }


//            dd($requerant_telephone,$defendeur_telephone);


            foreach ($dossier->getPieces() as $piece) {
                $piece->setDossier($dossier);
            }
            $dossier->setStructure(1);
            $dossier->setCreatedBy($this->getUser());
            $dossierRepository->add($dossier, true);
            $this->addFlash('success', 'La réquete a été enregistrée avec success');
            return $this->redirectToRoute('app_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('special/requete_special.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route(path: '/pouvoir-cassation', name: 'greffier_chef_pouvoir_cassation_new')]
    public function pouvoirCassation(Request $request, DossierRepository $dossierRepository, ArrondissementRepository $arrondissementRepository, DefendeurRepository $defendeurRepository
        , PartieRepository $requerantRepository): Response
    {
        $dossier = new Dossier();
        $form = $this->createForm(DossierSpecialType::class, $dossier);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

//            dd($request->request->get("city"));
            // dd($arrondissementRepository->find($request->request->get("localite_requerent")),$arrondissementRepository->find($request->request->get("localite_defendeur")));
            // Recuperation des id de la locallite du requerent et du defendeur
//            $localite_requerant_id= $request->request->get("localite_requerent");
//            $localite_defendeur_id=$request->request->get("localite_defendeur");
//            $localite_requerant= $arrondissementRepository->find( $localite_requerant_id);
//            $localite_defendeur=  $arrondissementRepository->find($localite_defendeur_id);
//            $dossier->getRequerant()->setLocalite( $localite_requerant);
//            $dossier->getDefendeur()->setLocalite( $localite_defendeur);

            $requerant_telephone = $form->get('requerant')->get('Telephone')->getData();
            $defendeur_telephone = $form->get('defendeur')->get('telephone')->getData();
//            $defendeur_telephone = $form->get('defendeur')->get('telephone')->getData();
            $requerant_exist = $requerantRepository->findOneBy(['Telephone' => $requerant_telephone]);
            $defendeur_exist = $defendeurRepository->findOneBy(['telephone' => $defendeur_telephone]);

            if ($requerant_exist) {
                $dossier->setRequerant($requerant_exist);
            } else {
                $localite_requerant_id = $request->request->get("localite_requerent");
                $localite_requerant = $arrondissementRepository->find($localite_requerant_id);
                $dossier->getRequerant()->setLocalite($localite_requerant);
            }


            if ($defendeur_exist) {
                $dossier->setDefendeur($defendeur_exist);
            } else {
                $localite_defendeur_id = $request->request->get("localite_defendeur");
                $localite_defendeur = $arrondissementRepository->find($localite_defendeur_id);
                $dossier->getDefendeur()->setLocalite($localite_defendeur);

            }


//            dd($requerant_telephone,$defendeur_telephone);


            foreach ($dossier->getPieces() as $piece) {
                $piece->setDossier($dossier);
            }
            $dossier->setStructure(1);
            $dossier->setCreatedBy($this->getUser());
            $dossierRepository->add($dossier, true);
            $this->addFlash('success', 'La réquete a été enregistrée avec success');
            return $this->redirectToRoute('app_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('special/requete_special.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }


}
