<?php

namespace App\Controller;

use App\Form\AffectationParSectionType;
use App\Form\AffectationParStructureType;
use App\Form\RequeteParPeriodeType;
use App\Repository\AffecterSectionRepository;
use App\Repository\AffecterStructureRepository;
use App\Repository\DossierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




#[Route(path: '/statistiques', name: 'app_statistiques')]
class StatistiquesController extends AbstractController
{
    #[Route(path: '/listerequetes', name: 'liste_requete')]
    public function listedesRequetes(DossierRepository $dossierRepository): Response
    {

        //$nbre= $dossierRepository->ListedesDossiersParPeriodet('2022-11-21 00:00:00','2022-11-21 00:00:00');

        //  dd($nbre);


        $listedesrequetes = $dossierRepository->findBy([
            'etatDossier' => null
        ]);
        return $this->render('statistiques/index.html.twig', [
            'nombre' => count($listedesrequetes),
            'dossiers' => $listedesrequetes
        ]);
    }


    #[Route(path: '/listerequetes/par/periode', name: 'liste_requete_periode')]
    public function listedesRequetsParPeriode(Request $request, DossierRepository $dossierRepository): Response
    {
        $form = $this->createForm(RequeteParPeriodeType::class);
        //dd($form);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $debut = $form->getData()['datedebut'];
            $fin = $form->getData()['datefin'];
            if ($form->getData()['datefin'] < $form->getData()['datedebut']) {
                $this->addFlash('warning',
                    'La date de fin ne peut pas être inférieure à la date de début');
                $this->redirectToRoute('app_statistiquesliste_requete_periode');

            } else {
                $dossiers = $dossierRepository->ListedesDossiersParPeriodet($debut, $fin);

                return $this->render('statistiques/listedesrequetesparperiode.html.twig', [
                    'nombre' => count($dossiers),
                    'dossiers' => $dossiers,
                    'date_debut' => $debut,
                    'date_fin' => $fin
                ]);


            }

        }

        return $this->render('statistiques/requeteparperiode.html.twig', [
            'form' => $form->createView()

        ]);


        //    $nbre= $dossierRepository->ListedesDossiersParPeriodet('2022-11-21 00:00:00','2022-11-21 00:00:00');


    }

    #[Route(path: '/listedesdossiers', name: 'liste_dossiers_crees')]
    public function listedesDossiers(DossierRepository $dossierRepository): Response
    {

        $listedesdossiers = $dossierRepository->findBy([
            'etatDossier' => "OUVERT"
        ]);

        // dd($listedesdossiers);
        return $this->render('statistiques/listedesdossierscrees.html.twig', [
            'nombre' => count($listedesdossiers),
            'dossiers' => $listedesdossiers
        ]);
    }


    #[Route(path: '/listedossiers/par/periode', name: 'liste_dossier_periode')]
    public function listedesDossiersCreessParPeriode(Request $request, DossierRepository $dossierRepository): Response
    {
        $form = $this->createForm(RequeteParPeriodeType::class);
        //dd($form);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $debut = $form->getData()['datedebut'];
            $fin = $form->getData()['datefin'];
            if ($form->getData()['datefin'] < $form->getData()['datedebut']) {
                $this->addFlash('warning',
                    'La date de fin ne peut pas être inférieure à la date de début');
                $this->redirectToRoute('app_statistiquesliste_requete_periode');

            } else {
                $dossiers = $dossierRepository->ListedesDossiersCreeParPeriodet($debut, $fin);

                return $this->render('statistiques/listedesrequetesparperiode.html.twig', [
                    'nombre' => count($dossiers),
                    'dossiers' => $dossiers,
                    'date_debut' => $debut,
                    'date_fin' => $fin
                ]);


            }

        }
        return $this->render('statistiques/requeteparperiode.html.twig', [
            'form' => $form->createView()

        ]);


    }

    #[Route(path: '/listedesaffectations/structure', name: 'liste_affectation_structure')]
    public function listedesAffectations(AffecterStructureRepository $affecterStructureRepository): Response
    {

        //$nbre= $dossierRepository->ListedesDossiersParPeriodet('2022-11-21 00:00:00','2022-11-21 00:00:00');

        //  dd($nbre);


        $listedesaffectationsstructures = $affecterStructureRepository->findAll();
       // dd($listedesaffectationsstructures);
        return $this->render('statistiques/listedesaffectationstructure.html.twig', [
            'nombre' => count($listedesaffectationsstructures),
            'dossiers' => $listedesaffectationsstructures
        ]);
    }


    #[Route(path: '/listedesaffectations/par/structure', name: 'liste_affectation_par_structure')]
    public function listedesAffectationsParStructure(Request $request, AffecterStructureRepository $affecterStructureRepository): Response
    {
        $form = $this->createForm(AffectationParStructureType::class);
        //dd($form);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structure = $form->getData()['structure'];

                $affectation = $affecterStructureRepository->findBy([
                    'structure'=>$structure
                ]);

               // dd($affectation);

                return $this->render('statistiques/listedesaffectationsparstructure.html.twig', [
                    'nombre' => count($affectation),
                    'dossiers' => $affectation,
                    'structure' => $structure
                ]);


            }



        return $this->render('statistiques/affectationparstructure.html.twig', [
            'form' => $form->createView()

        ]);




    }


    #[Route(path: '/listedesaffectations/section', name: 'liste_affectation_section')]
    public function listedesAffectationsSection(AffecterSectionRepository $affecterSectionRepository): Response
    {

        //$nbre= $dossierRepository->ListedesDossiersParPeriodet('2022-11-21 00:00:00','2022-11-21 00:00:00');

        //  dd($nbre);


        $listedesaffectationssections = $affecterSectionRepository->findAll();

        return $this->render('statistiques/listedesaffectationsection.html.twig', [
            'nombre' => count($listedesaffectationssections),
            'dossiers' => $listedesaffectationssections
        ]);
    }


    #[Route(path: '/listedesaffectations/par/section', name: 'liste_affectation_par_section')]
    public function listedesAffectationsParSection(Request $request,AffecterSectionRepository $affecterSectionRepository ): Response
    {
        $form = $this->createForm(AffectationParSectionType::class);
        //dd($form);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structure = $form->getData()['section'];

            $affectation = $affecterSectionRepository->findBy([
                'section'=>$structure
            ]);

            // dd($affectation);

            return $this->render('statistiques/listedesaffectationsparsection.html.twig', [
                'nombre' => count($affectation),
                'dossiers' => $affectation,
                'structure' => $structure
            ]);


        }



        return $this->render('statistiques/affectationparsection.html.twig', [
            'form' => $form->createView()

        ]);




    }

}
