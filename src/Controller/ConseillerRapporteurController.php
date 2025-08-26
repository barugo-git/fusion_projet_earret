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
use App\Repository\InstructionsRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/conseiller-rapporteur')]
#[IsGranted('ROLE_CONSEILLER')]
class ConseillerRapporteurController extends AbstractController
{
    #[Route(path: '/', name: 'app_conseiller_rapporteur')]
    public function index(DossierRepository $dossierRepository): Response
    {
        return $this->render('conseiller_rapporteur/cr_index_ouverture.html.twig', [
            'dossiers' => $dossierRepository->listeDossierOuvertParConseillerRapporteur($this->getUser()),
        ]);
    }

    #[Route(path: '/mesures-instructions', name: 'app_conseiller_rapporteur_liste_mesures_instructions')]
    public function listeMesuresInstructions(MesuresInstructionsRepository $mesuresInstructionsRepository): Response
    {
        return $this->render('conseiller_rapporteur/liste_mesure_instruction.html.twig', [
            'mesures' => $mesuresInstructionsRepository->findBy(['conseillerRapporteur' => $this->getUser()]),
        ]);
    }

    #[Route(path: '/nouvelle-mesure-instruction/dossier/{id}', name: 'app_conseiller_rapporteur_nouvelle_mesure_instruction')]
    public function mesuresInstruction(
        Request $request,
        Dossier $dossier,
        EntityManagerInterface $entityManager,
        UserDossierRepository $userDossierRepository,
        InstructionsRepository $instructionsRepository,
        MesuresInstructionsRepository $mesuresInstructionsRepository
    ): Response {
        $mesureInstruction = new MesuresInstructions();
        $form = $this->createForm(MesuresInstructionsType::class, $mesureInstruction);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $nouvelleInstructionLibelle = $request->request->get('nouvelle_instruction');
            $nouvelleInstructionDelai = $request->request->get('delai_nouvelle_instruction');

            $idgreffier = $userDossierRepository->findOneBy([
                'dossier' => $dossier,
                'profil' => 'GREFFIER'
            ]);

            if (!empty($nouvelleInstructionLibelle) && !empty($nouvelleInstructionDelai)) {
                $instruction = new Instructions();
                $instruction->setLibelle($nouvelleInstructionLibelle);
                $instruction->setDelais((int)$nouvelleInstructionDelai);
                $instruction->setActive(true);

                $entityManager->persist($instruction);
                $entityManager->flush();

                $mesureInstruction->setInstruction($instruction);
                $delai = $nouvelleInstructionDelai;
            } else {
                $instruction = $form->get('instruction')->getData();
                if (!$instruction) {
                    $this->addFlash('error', 'Aucune instruction sélectionnée ou créée');
                    return $this->render('conseiller_rapporteur/new_mesures_instructins.html.twig', [
                        'dossier' => $dossier,
                        'form' => $form->createView(),
                    ]);
                }
                $mesureInstruction->setInstruction($instruction);
                $delai = $instruction->getDelais();
            }

            $mesureInstruction->setGreffier($idgreffier->getUser());
            $mesureInstruction->setDossier($dossier);
            $mesureInstruction->setCreatedAt(new \DateTime());
            $mesureInstruction->setTermineAt((clone $mesureInstruction->getCreatedAt())->modify("+{$delai} days"));
            if ($this->isGranted('ROLE_CONSEILLER')) {
                $mesureInstruction->setConseillerRapporteur($this->getUser());
            }

            $partiesConcernes = $form->get('partiesConcernes')->getData();
            $mesureInstruction->setPartiesConcernes($partiesConcernes);

            $observations = $form->get('observations')->getData();
            if ($observations) {
                $mesureInstruction->setObservations($observations);
            }
            $mesureInstruction->setEtat('EN COURS');
            $entityManager->persist($mesureInstruction);
            $entityManager->flush();

            $this->addFlash('success', 'La mesure d\'instruction a été créée avec succès.');

                    $greffier = null;

                foreach ($dossier->getUserDossier() as $userDossier) {
                    if ($userDossier->getProfil() === 'GREFFIER') {
                        $greffier = $userDossier->getUser();
                        break;
                    }
                }

                if ($greffier) {
                    $nomGreffier = $greffier->getNom(); // ou getFullName() selon ton entité User
                } else {
                    $nomGreffier = 'Aucun greffier affecté';
                }


             $sujet = 'Nouvelle Mesure d\'instruction';

                    $context = [
                        'greffier' => $nomGreffier
                        'numeroRecours' => $dossier->getReferenceDossier() ?? $dossier->getCodeSuivi(),
                        'mesureInstruction'=> $nouvelleInstructionLibelle ,
                        'lien' => $this->generateUrl('front_recours_status', [], UrlGeneratorInterface::ABSOLUTE_URL)

                    ];

                    $mailService->sendEmail($mail, $sujet, 'resume.html.twig', $context);

                    return $this->redirectToRoute('greffier_mesures_instructions_dossier_list', ['id' => $dossier->getId()]);

        }

        

        return $this->render('conseiller_rapporteur/new_mesures_instructins.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/reposnse-mesures-instruction/instruction/{id}', name: 'app_conseiller_rapporteur_mesures_instructions_reponse')]
    public function reponseMesuresInstruction(Request $request, MesuresInstructions $mesuresInstructions): Response
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
    public function rapportConseillerRapporteur(Request $request, Dossier $dossier, UserRepository $userRepository, StatutRepository $statutRepository, EntityManagerInterface $em, DossierRepository $dossierRepository, FileUploader $fileUploader, UserDossierRepository $userDossierRepository): Response
    {
        $form = $this->createForm(RapportConseillerRapporteurType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->setFinMesuresInstruction(true);
            $dossier->setFinMesuresInstructionAt(new \DateTime());

            $mouvement = new Mouvement();
            $mouvement->setDateMouvement(new \DateTime());
            $statut = $statutRepository->findOneBy(['libelle' => 'Dossier au Rôle']);
            $mouvement->setStatut($statut);

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

            if ($form->get('document')->getData()) {
                $image = $form->get('document')->getData();
                $fmane = $dossier->getReferenceDossier();
                $fichier = $fileUploader->upload($image, $fmane, 'piecesJointes');
                $dossier->setRapportCR($fichier);
            }

            $em->persist($affectation);
            $dossierRepository->add($dossier, true);

            $this->addFlash('success', 'Le rapport a été uploadé avec succès');
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
        $conclusion = $dossierRepository->listeConclusionPGParConseillerRapporteur($this->getUser());
        return $this->render('conseiller_rapporteur/conclusion_parquet.html.twig', [
            'dossiers' => $conclusion
        ]);
    }

    #[Route(path: '/nouvelle-mesure-instruction-avis-parties/dossier/{id}', name: 'cr_mesure_instruction_avis_partie')]
    public function mesuresInstructionConclusion(UserRepository $userRepository, UserDossierRepository $userDossierRepository, MesuresInstructionsRepository $mesuresInstructionsRepository, Request $request, DossierRepository $dossierRepository, Dossier $dossier): Response
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
