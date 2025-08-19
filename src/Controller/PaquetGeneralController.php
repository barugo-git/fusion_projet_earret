<?php

namespace App\Controller;

use App\Entity\AffecterStructure;
use App\Entity\Dossier;
use App\Entity\MesuresInstructions;
use App\Entity\Mouvement;
use App\Entity\Pieces;
use App\Entity\ReponseMesuresInstructions;
use App\Entity\UserDossier;
use App\Form\AffectationParquetType;
use App\Form\AffectationUserType;
use App\Form\AffecterStructureType;
use App\Form\ReponseMesureType;
use App\Form\RetourAffecterStructureType;
use App\Repository\AffecterStructureRepository;
use App\Repository\DossierRepository;
use App\Repository\MesuresInstructionsRepository;
use App\Repository\ReponseMesuresInstructionsRepository;
use App\Repository\UserDossierRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/paquet-general/dossiers')]
#[IsGranted('ROLE_PROCUREUR_GENERAL')]
class PaquetGeneralController extends AbstractController
{
    #[Route(path: '/', name: 'paquet_general_index')]
    public function index(DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
    {
//        $dossiers = $dossierRepository->recoursAffecteParStructure('PG');
        $dossiers = $dossierRepository->dossierAAffecteAuPG();
        //dd($dossiers);
        return $this->render('parquet/index_affectation.html.twig', [
            'dossiers' => $dossiers,
        ]);
    }
    #[Route(path: '/dossier-a-transmettre-au-president-de-chambre', name: 'paquet_general_affectation_pc_index')]
    public function dossierAAffecterAuPC(DossierRepository $dossierRepository): Response
    {
        $dossiers = $dossierRepository->dossierAAffecteAuPC();
//        dd($dossiers[0]->getPiecesDoc()[0]->getUrl());
        return $this->render('parquet/index_affectation_paquet.html.twig', [
            'dossiers' => $dossiers,
        ]);
    }
    #[Route(path: '/affecter-un-avocat-general/{id}', name: 'parquet_general_affectations_avocat')]
    public function affecteUnAvocatGeneral(Request $request, Dossier $dossier, UserDossierRepository $userDossierRepository, DossierRepository $dossierRepository, MesuresInstructionsRepository $mesuresInstructionsRepository)
    {
        $affectation = new UserDossier();
        $mesure= new MesuresInstructions();
        $form = $this->createForm(AffectationParquetType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $instructions =  $form->get('mesure')->getData();
            $avocat = $form->get('user')->getData();

            $dossier->setEtatDossier("AFFECTE");
            $dossierRepository->add($dossier);

            $affectation->setDossier($dossier);
            $affectation->setProfil('AVOCAT GENERAL');
            $affectation->setNature('AFFECTATION');
            $userDossierRepository->add($affectation, true);

            $mesure->setInstruction($instructions->getInstruction());
            $mesure->setDossier($dossier);

            $mesure->setDate(new \DateTimeImmutable()) ;

            //Enregistrement du Procureur General
            $mesure->setConseillerRapporteur($this->getUser());

            //Enregistrement de l'avocat General
            $mesure->setGreffier($avocat) ;

            $mesure->setNature('PG');

            $mesure->setDelais($instructions->getDelais());

            $mesuresInstructionsRepository->add($mesure,true);
            $this->addFlash('success', 'le dossier a été bien affecté à l\'avocat');
            return $this->redirectToRoute('paquet_general_index');
        }

        return $this->render('parquet/new_affectation_avocat.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/liste-mesures-instructions/dossier', name: 'pg_mesures_instructions_dossier_list')]
    public function ListemesuresInstruction(MesuresInstructionsRepository $mesuresInstructionsRepository): \Symfony\Component\HttpFoundation\Response
    {
        //dd($mesuresInstructions);
        return $this->render('parquet/pag_liste_instruction.html.twig', [
            'mesures' => $mesuresInstructionsRepository->findBy(['nature' => 'PG']),
//            'dossier' => $dossier
        ]);
    }

    #[Route(path: '/affectation/dossier/structure/{id}', name: 'pg_affecter_dossier_structure_new', methods: ['GET', 'POST'])]
    public function affectionChambre(DossierRepository $dossierRepository,Request $request,
                                     AffecterStructureRepository $affecterStructureRepository,
                                     Dossier $dossier,FileUploader $fileUploader,EntityManagerInterface $entityManager): Response
    {
        $affecterStructure = new AffecterStructure();

        $structureAffectante = $affecterStructureRepository->findOneBy(['structure'=>$this->getUser()->getStructure()])->getDe();

        $affecterStructure->setDossier($dossier);
        $form = $this->createForm(RetourAffecterStructureType::class, $affecterStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affecterStructure->setStructure($structureAffectante);

            // Chagement du statuts du dossier et enregistement de l'historique
//            $mouvement = new Mouvement();
//            $mouvement->setDateMouvement(new \DateTime());
//            $statut = $statutRepository->findOneBy(['libelle'=>'Dossier au Rôle']);
//            $mouvement->setStatut($statut);

            $affecterStructure->setDateAffection(new \DateTimeImmutable());
//            $affecterStructure->set;
            $dossier->setEtatDossier("CONCLUSION DISPONIBLE");
//            if ($form->get('document')->getData()) {
//                $image = $form->get('document')->getData();
//                $fmane = $dossier->getReferenceDossier();
//                $fichier = $fileUploader->upload($image, $fmane, 'piecesJointes');

//               $piece = new Pieces();
//                $piece->setUrl($fichier)
//                    ->setAuteur($this->getUser())
//                    ->setNaturePiece('RAPPORT AVOCAT GENERAL')
//                    ->setCreatedAt(new  \DateTimeImmutable())
//                    ->setDescriptionPiece($form->get('motif')->getData())
//                    ;
//                $entityManager->persist($piece);
//            }
            $dossierRepository->add($dossier,true);
            $affecterStructure->setDe($this->getUser()->getStructure());
            $affecterStructureRepository->add($affecterStructure, true);
            $this->addFlash('success', 'le dossier a été bien au président de la : ' . $structureAffectante->getName());

            return $this->redirectToRoute('paquet_general_index');
        }

        return $this->render('parquet/retour_affectation_new.html.twig', [
//            'affecter_structure' => $affecterStructure,
            'dossier' => $dossier,
            'form' => $form,
            'structure'=>$structureAffectante
        ]);
    }
    #[Route(path: '/reposnse-mesures-instruction/instruction/show/{id}', name: 'pg_rapporteur_mesures_instructions_reponse_show')]
    public function detailsmesuresInstruction(DossierRepository $dossierRepository,
                                              MesuresInstructions $mesuresInstructions, ReponseMesuresInstructionsRepository $reponseMesuresInstructionsRepository): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('parquet/details_mesures_instructins_pg.html.twig', [
            'mesures' => $mesuresInstructions,

        ]);
    }

    #[Route(path: '/reponse-mesures-instruction/instruction/show/{id}', name: 'pg_mesures_instructions_reponse_show')]
    public function detailsmesuresInstructions(DossierRepository   $dossierRepository,
                                              MesuresInstructions $mesuresInstructions, ReponseMesuresInstructionsRepository $reponseMesuresInstructionsRepository): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('conseiller_rapporteur/details_mesures_instructins.html.twig', [
            'mesures' => $mesuresInstructions,
            //  'dossiers'=>
        ]);
    }

    #[Route(path: '/reponse-mesures-pg-instruction/instruction/edit/{id}', name: 'pg_ag_mesures_instructions_reponse_edit')]
    public function reponsemesuresInstructionComplete(Request   $request, DossierRepository $dossierRepository,
                                                      ReponseMesuresInstructions $reponseMesuresInstructions, ReponseMesuresInstructionsRepository $reponseMesuresInstructionsRepository)
    {
//        $reponse = new ReponseMesuresInstructions();
        $form = $this->createForm(ReponseMesureType::class, $reponseMesuresInstructions);
        $form->handleRequest($request);
        $dossier = $reponseMesuresInstructions->getMesure()->getDossier()->getId();
        if ($form->isSubmitted() && $form->isValid()) {

            $reponseMesuresInstructionsRepository->add($reponseMesuresInstructions, true);
            return $this->redirectToRoute('greffier_mesures_instructions_dossier_list', ['id' => $dossier]);
        }
        return $this->render('conseiller_rapporteur/reponses_mesures_instructins.html.twig', [
            'mesures' => $reponseMesuresInstructions->getMesure(),
            'form' => $form->createView(),
            'dossier' => $dossier
        ]);
    }
}
