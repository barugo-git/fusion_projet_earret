<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Dossier;
use App\Entity\MesuresInstructions;
use App\Repository\DossierRepository;
use App\Repository\MesuresInstructionsRepository;
use App\Repository\ReponseMesuresInstructionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommunController extends AbstractController
{
    #[Route(path: '/mesures-instructions/dossier/{id}', name: 'greffier_mesures_instructions_dossier_list')]
    public function listeMesuresInstruction(MesuresInstructionsRepository $mesuresInstructionsRepository, Dossier $dossier): \Symfony\Component\HttpFoundation\Response
    {
        //dd($mesuresInstructions);
        return $this->render('greffe/greffe_liste_instruction_par_dossier.html.twig', [
            'mesures' => $mesuresInstructionsRepository->findBy([
                'dossier' => $dossier,
                'nature' => [null,'AVIS DEUX PARTIES']
                ]),
            'dossier' => $dossier
        ]);
    }

    #[Route(path: '/greffier/dossiers/reposnse-mesures-instruction/instruction/show/{id}', name: 'greffier_rapporteur_mesures_instructions_reponse_show')]
    public function detailsmesuresInstruction(DossierRepository   $dossierRepository,
                                              MesuresInstructions $mesuresInstructions, ReponseMesuresInstructionsRepository $reponseMesuresInstructionsRepository): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('conseiller_rapporteur/details_mesures_instructins.html.twig', [
            'mesures' => $mesuresInstructions,
          //  'dossiers'=>
        ]);
    }
}
