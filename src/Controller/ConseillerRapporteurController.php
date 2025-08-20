<?php

namespace App\Controller;

use App\Entity\AffecterUser;
use App\Entity\Dossier;
use App\Entity\MesuresInstructions;
use App\Entity\Mouvement;
use App\Entity\ReponseMesuresInstructions;
use App\Entity\Instructions;
use App\Form\MesuresInstructionsConclusionsType;
use App\Form\MesuresInstructionsType;
use App\Form\RapportConseillerRapporteurType;
use App\Form\ReponseMesureType;
use App\Repository\DossierRepository;
use App\Repository\MesuresInstructionsRepository;
use App\Repository\MouvementRepository;
use App\Repository\StatutRepository;
use App\Repository\UserDossierRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\InstructionsRepository;

#[Route(path: '/conseiller-rapporteur')]
#[IsGranted('ROLE_CONSEILLER')]
class ConseillerRapporteurController extends AbstractController
{
    #[Route(path: '/', name: 'app_conseiller_rapporteur')]
    public function index(DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('conseiller_rapporteur/cr_index_ouverture.html.twig', [
            'dossiers' => $dossierRepository->listeDossierOuvertParConseillerRapporteur($this->getUser()),
        ]);
    }

    #[Route(path: '/mesures-instructions', name: 'app_conseiller_rapporteur_liste_mesures_instructions')]
    public function listeMesuresInstructions(MesuresInstructionsRepository $mesuresInstructionsRepository): \Symfony\Component\HttpFoundation\Response
    {
        //      dd($mesuresInstructionsRepository->findBy(['conseillerRapporteur' => $this->getUser()])) ;

        return $this->render('conseiller_rapporteur/liste_mesure_instruction.html.twig', [
            'mesures' => $mesuresInstructionsRepository->findBy(['conseillerRapporteur' => $this->getUser()]),
            //  'dossiers' =>$mesuresInstructionsRepository->findBy(['conseillerRapporteur' => $this->getUser()])->getDossier()
        ]);
        //        return $this->render('conseiller_rapporteur/cr_index_ouverture.html.twig', [
        //            'dossiers' => $dossierRepository->listeDossierOuvertParConseillerRapporteur($this->getUser()),
        //        ]);
    }


    #[Route(path: '/nouvelle-mesure-instruction/dossier/{id}', name: 'app_conseiller_rapporteur_nouvelle_mesure_instruction')]
    public function mesuresInstruction(
        Request $request,
        Dossier $dossier,
        EntityManagerInterface $entityManager,
        UserDossierRepository $userDossierRepository,
        InstructionsRepository $instructionsRepository
    ): Response {
        $mesureInstruction = new MesuresInstructions();
        $form = $this->createForm(MesuresInstructionsType::class, $mesureInstruction);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Dump des données reçues du formulaire
            dump('Données POST reçues:', $request->request->all());

            // Récupérer les données de la nouvelle instruction
            $nouvelleInstructionLibelle = $request->request->get('nouvelle_instruction');
            $nouvelleInstructionDelai = $request->request->get('delai_nouvelle_instruction');

            dump('Données nouvelle instruction:', [
                'libelle' => $nouvelleInstructionLibelle,
                'delai' => $nouvelleInstructionDelai
            ]);

            try {
                // Récupérer le greffier
                $idgreffier = $userDossierRepository->findOneBy([
                    'dossier' => $dossier,
                    'profil' => 'GREFFIER'
                ]);

                if (!empty($nouvelleInstructionLibelle) && !empty($nouvelleInstructionDelai)) {
                    // Créer la nouvelle instruction
                    $instruction = new Instructions();
                    $instruction->setLibelle($nouvelleInstructionLibelle);
                    $instruction->setDelais((int)$nouvelleInstructionDelai);
                    $instruction->setActive(true);

                    $entityManager->persist($instruction);
                    $entityManager->flush();

                    dump('Nouvelle instruction créée:', $instruction);

                    // Configurer la mesure d'instruction avec la nouvelle instruction
                    $mesureInstruction->setInstruction($instruction);
                    $delai = $nouvelleInstructionDelai;
                } else {
                    // Utiliser l'instruction existante
                    $instruction = $form->get('instruction')->getData();
                    dump('Instruction existante utilisée:', $instruction);

                    if (!$instruction) {
                        throw new \Exception('Aucune instruction sélectionnée ou créée');
                    }
                    $delai = $instruction->getDelais();
                }

                // Configuration de la mesure d'instruction
                $mesureInstruction->setGreffier($idgreffier->getUser());
                $mesureInstruction->setDossier($dossier);
                $mesureInstruction->setCreatedAt(new \DateTime());
                $mesureInstruction->setTermineAt(
                    (clone $mesureInstruction->getCreatedAt())->modify("+{$delai} days")
                );

                if ($this->isGranted('ROLE_CONSEILLER')) {
                    $mesureInstruction->setConseillerRapporteur($this->getUser());
                }

                // Récupérer et définir les parties concernées et observations
                $partiesConcernes = $form->get('partiesConcernes')->getData();
                $mesureInstruction->setPartiesConcernes($partiesConcernes);

                $observations = $form->get('observations')->getData();
                if ($observations) {
                    $mesureInstruction->setObservations($observations);
                }

                dump('Mesure d\'instruction avant persistance:', $mesureInstruction);

                // Persister la mesure d'instruction
                $entityManager->persist($mesureInstruction);
                $entityManager->flush();

                dump('Mesure d\'instruction après persistance:', $mesureInstruction);

                $this->addFlash('success', 'La mesure d\'instruction a été créée avec succès.');
                return $this->redirectToRoute('greffier_mesures_instructions_dossier_list', ['id' => $dossier->getId()]);
            } catch (\Exception $e) {
                dump('Erreur:', $e->getMessage(), $e->getTraceAsString());
                $this->addFlash('error', 'Erreur lors de l\'enregistrement : ' . $e->getMessage());
            }
        }

        return $this->render('conseiller_rapporteur/new_mesures_instructins.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }



    #[Route(path: '/reposnse-mesures-instruction/instruction/{id}', name: 'app_conseiller_rapporteur_mesures_instructions_reponse')]
    public function reponseMesuresInstruction(Request $request, DossierRepository $dossierRepository, MesuresInstructions $mesuresInstructions): \Symfony\Component\HttpFoundation\Response
    {
        $reponse = new ReponseMesuresInstructions();
        $form = $this->createForm(ReponseMesureType::class, $reponse);
        $form->handleRequest($request);
        return $this->render('conseiller_rapporteur/reponses_mesures_instructins.html.twig', [
            'mesures' => $mesuresInstructions,
            'form' => $form->createView(),
        ]);
    }


    #[Route(path: '/rapport-mesures-instructions/{id}', name: 'app_conseiller_rapporteur_rapport')]
    public function rapportConseillerRapporteur(Request $request, Dossier $dossier, UserRepository $userRepository, StatutRepository $statutRepository, EntityManagerInterface $em, DossierRepository $dossierRepository, FileUploader $fileUploader, UserDossierRepository $userDossierRepository)
    {
        $form = $this->createForm(RapportConseillerRapporteurType::class, $dossier);
        $form->handleRequest($request);



        //dd( $greffier );
        if ($form->isSubmitted() && $form->isValid()) {


            $dossier->setFinMesuresInstruction(true);
            $dossier->setFinMesuresInstructionAt(new \DateTime());

            // Chagement du statuts du dossier et enregistement de l'historique
            $mouvement = new Mouvement();
            $mouvement->setDateMouvement(new \DateTime());
            $statut = $statutRepository->findOneBy(['libelle' => 'Dossier au Rôle']);
            $mouvement->setStatut($statut);

            //Greffier du dossier
            $greffier = $userDossierRepository->findOneBy(['dossier' => $dossier, 'profil' => ['GREFFIER', 'GREFFIER EN CHEF']]);
            $mouvement->setUser($greffier->getUser());
            $mouvement->setDossier($dossier);
            $dossier->setStatut($mouvement->getStatut()->getLibelle());

            $em->persist($mouvement);
            $affectation = new AffecterUser();
            $affectation->setDossier($dossier);
            $affectation->setExpediteur($this->getUser());
            $presidentChambre = $userRepository->findOneBy(['structure' => $this->getUser()->getStructure(), 'titre' => ['PRESIDENT DE STRUCTURE']]);
            $affectation->setDestinataire($presidentChambre);
            $affectation->setDateAffection(new \DateTime());
            $affectation->setMotif("Rapport de fin d'instruction");

            // TODO : envoyer un mail au president de structure lors l'affectation

            if ($form->get('document')->getData()) {
                $image = $form->get('document')->getData();
                $fmane = $dossier->getReferenceDossier();
                $fichier = $fileUploader->upload($image, $fmane, 'piecesJointes');
                $dossier->setRapportCR($fichier);
            }
            $em->persist($affectation);

            $dossierRepository->add($dossier, true);
            $this->addFlash('success', 'Le rapport a été uploadé avec success');
            return $this->redirectToRoute('greffier_dossier_open_list');
        }

        return $this->render('conseiller_rapporteur/productionRapport.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }


    #[Route(path: '/conclusions-parquets', name: 'cr_conclusion_parquet', methods: ['GET', 'POST'])]
    public function conclusionDuParquet(DossierRepository $dossierRepository): Response
    {
        //        $structure = $this->getUser()->getStructure();
        $conclusion = $dossierRepository->listeConclusionPGParConseillerRapporteur($this->getUser());
        //        dd(    $conclusion);
        return $this->render('conseiller_rapporteur/conclusion_parquet.html.twig', [
            'dossiers' => $conclusion
        ]);
    }


    #[Route(path: '/nouvelle-mesure-instruction-avis-parties/dossier/{id}', name: 'cr_mesure_instruction_avis_partie')]
    public function mesuresInstructionConclusion(UserRepository $userRepository, UserDossierRepository $userDossierRepository, MesuresInstructionsRepository $mesuresInstructionsRepository, Request $request, DossierRepository $dossierRepository, Dossier $dossier)
    {
        $instructions = new MesuresInstructions();
        $instructions->setInstruction("TRANSMETTRE LES CONCLUSIONS DU PARQUET GENERAL AUX DEUX PARTIES POUR AVIS");
        $instructions->setDelais(90);
        $instructions->setNature('AVIS DEUX PARTIES');
        $instructions->setPartiesConcernes('Aux deux Parties');
        $form = $this->createForm(MesuresInstructionsConclusionsType::class, $instructions);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $idgreffier = $userDossierRepository->findOneBy([
                'dossier' => $dossier,
                'profil' => 'GREFFIER'
            ]);
            //    $iduser=$userRepository->find($idgreffier->getId()->toBinary());

            $instructions->setGreffier($idgreffier->getUser());
            $instructions->setDossier($dossier);
            if (in_array('ROLE_CONSEILLER', $this->getUser()->getRoles(), true)) {
                $instructions->setConseillerRapporteur($this->getUser());
            }

            $dossier->setEtatDossier('AVIS GREFFE');

            $mesuresInstructionsRepository->add($instructions, true);
            return $this->redirectToRoute('greffier_mesures_instructions_dossier_list', ['id' => $dossier->getId()]);
        }
        return $this->render('conseiller_rapporteur/new_mesures_instructins.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }
}
