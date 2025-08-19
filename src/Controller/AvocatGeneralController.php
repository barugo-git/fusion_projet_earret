<?php

namespace App\Controller;

use App\Entity\AffecterStructure;
use App\Entity\Dossier;
use App\Entity\MesuresInstructions;
use App\Entity\Pieces;
use App\Entity\ReponseMesuresInstructions;
use App\Form\ReponseMesureAGType;
use App\Form\ReponseMesureType;
use App\Repository\AffecterStructureRepository;
use App\Repository\DossierRepository;
use App\Repository\MesuresInstructionsRepository;
use App\Repository\ReponseMesuresInstructionsRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/avocat-general/dossier')]
#[IsGranted('ROLE_AVOCAT_GENERAL')]
class AvocatGeneralController extends AbstractController
{
    #[Route(path: '/liste-des-dossiers', name: 'avocat_list_dossier_affectee')]
    public function listDossierAffecte(DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response{
        $dossiers = $dossierRepository->recoursAffecteParAG($this->getUser());
//        dd($dossier);
        return $this->render('parquet/liste-dossier-avocat.html.twig', [
            'dossiers' => $dossiers
        ]);
    }

    #[Route(path: '/mesures-instructions/dossier/{id}', name: 'avocat_general_mesures_instructions_list')]
    public function ListemesuresInstruction(MesuresInstructionsRepository $mesuresInstructionsRepository, Dossier $dossier): \Symfony\Component\HttpFoundation\Response
    {
        //dd($mesuresInstructions);
        return $this->render('parquet/avocat_general_liste_instruction_par_dossier.html.twig', [
            'mesures' => $mesuresInstructionsRepository->findBy(['dossier' => $dossier,'nature'=>'PG']),
            'dossier' => $dossier
        ]);
    }

    #[Route(path: '/reposnse-mesures-instruction/instruction/{id}', name: 'avocat_mesures_instructions_reponse')]
    public function reponseMesureInstructionAvocat(Request $request,  AffecterStructureRepository $affecterStructureRepository,DossierRepository $dossierRepository,
                                              MesuresInstructions $mesuresInstructions, ReponseMesuresInstructionsRepository $reponseMesuresInstructionsRepository,FileUploader $fileUploader,EntityManagerInterface $entityManager)
    {
        $reponse = new ReponseMesuresInstructions();
        $form = $this->createForm(ReponseMesureAGType::class, $reponse);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dossier = $mesuresInstructions->getDossier();
//            $affecterStructure = new AffecterStructure();
//            dd($this->getUser()->getStructure());
//            $structureAffectante = $affecterStructureRepository->findOneBy(['structure'=>$this->getUser()->getStructure()])->getDe();

//            $affecterStructure->setDossier($dossier);

            $dossier->setEtatDossier("CONCLUSION EN COURS");

            $image = $form->get('document')->getData();
            $fmane = $dossier->getReferenceDossier();
            $fichier = $fileUploader->upload($image, $fmane, 'piecesJointes');

            $piece = new Pieces();
            $piece->setUrl($fichier)
                ->setDossier($dossier)
                ->setAuteur($this->getUser())
                ->setNaturePiece('RAPPORT AVOCAT GENERAL')
                ->setCreatedAt(new  \DateTimeImmutable())
                ->setDescriptionPiece($form->get('motif')->getData())
            ;
            $entityManager->persist($piece);

//            $affecterStructure->setDe($this->getUser()->getStructure());
//            $affecterStru&ctureRepository->add($affecterStructure, true);

            $reponse->setMesure($mesuresInstructions);
            $reponseMesuresInstructionsRepository->add($reponse, true);

            $dossierRepository->add($dossier,true);
//            $affecterStructure->setDe($this->getUser()->getStructure());
//            $affecterStructureRepository->add($affecterStructure, true);
            $this->addFlash('success', 'le rapport a ete bien envoyé au Procureur Général : ');
            return $this->redirectToRoute('avocat_general_mesures_instructions_list', ['id' => $mesuresInstructions->getDossier()->getId()]);

        }
        return $this->render('parquet/reponses_mesures_instructions.html.twig', [
            'mesures' => $mesuresInstructions,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/reposnse-mesures-instruction/instruction/modification/{id}', name: 'avocat_general_mesures_instructions_reponse_edit')]
    public function reponsemesuresInstructionComplete(Request $request, DossierRepository $dossierRepository,
                                                      ReponseMesuresInstructions $reponseMesuresInstructions, ReponseMesuresInstructionsRepository $reponseMesuresInstructionsRepository)
    {
//        $reponse = new ReponseMesuresInstructions();
//        $form = $this->createForm(ReponseMesureAGType::class, $reponse);
        $form = $this->createForm(ReponseMesureAGType::class, $reponseMesuresInstructions);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dossier = $reponseMesuresInstructions->getMesure()->getDossier()->getId();
            $reponseMesuresInstructionsRepository->add($reponseMesuresInstructions, true);
            return $this->redirectToRoute('avocat_general_mesures_instructions_list', ['id' => $dossier]);
        }
        return $this->render('parquet/reponses_mesures_instructions_ag.html.twig', [
            'mesures' => $reponseMesuresInstructions->getMesure(),
            'form' => $form->createView(),
        ]);
    }

}
