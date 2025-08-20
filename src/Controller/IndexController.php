<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ArretsRepository;
use App\Repository\AudienceRepository;
use App\Repository\DossierRepository;
use App\Repository\UserDossierRepository;
use Psr\Log\LoggerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class IndexController extends AbstractController
{
    #[Route(path: '/dashboard', name: 'app_index')]
//    #[IsGranted('ROLE_USER')]
    public function index(#[CurrentUser] User $user , LoggerInterface $dbLogger,DossierRepository $dossierRepository, AudienceRepository $audienceRepository,ArretsRepository $arretsRepository,UserDossierRepository $userDossierRepository): Response
    {
        $dbLogger->info('Notre premier log');

        $nbredossierenattenteaudience=count($userDossierRepository->findAllDossierenAttente());

        $nbreaudiencesprogrammees=count($audienceRepository->findAll());
        $nbrearrets=count($audienceRepository->findAll());

        $nbrederequetesenregistres=count($dossierRepository->findBy([
            'etatDossier'=>null
        ]));
        $nbredossierouverts=count($dossierRepository->findBy([
            'etatDossier'=>"OUVERT"
        ]));
        //dd($nbredossierouverts);
        return $this->render('index.html.twig', [
            'controller_name' => 'IndexController',
            'nbrederequete'=>$nbrederequetesenregistres,
            'nbrededossierouvert'=>$nbredossierouverts,
            'nbreaudienceprogrammees'=>$nbreaudiencesprogrammees,
            'nbrearrets'=>$nbrearrets,
            'nbredossierenattenteaudience'=>$nbredossierenattenteaudience
        ]);
    }


//    #[Route(path: '/', name: 'app_index_test')]
//    public function test(): Response
//    {
//        return $this->render('forms-editors.html.twig', [
//            'controller_name' => 'IndexController',
//        ]);
//    }
}
