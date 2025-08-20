<?php

namespace App\Controller;

use App\Entity\Defendeur;
use App\Entity\Partie;

use App\Entity\Section;
use App\Repository\ArrondissementRepository;
use App\Repository\CommuneRepository;
use App\Repository\SectionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


#[Route(path: '/ajax')]
class AjaxController extends AbstractController
{
   // private EntityManagerInterface $entityManager;
    public function __construct( private  EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;

    }


    #[Route(path: '/requerant/{Telephone}', name: 'ajax_requerant_telephone')]
    public function findRequerantByTelephone(Partie $requerant)
    {


        $data = [];
        if ($requerant) {
            $data = [
                'id' => $requerant->getId(),
                'email' => $requerant->getEmail(),
                'nom' => $requerant->getNom(),
                'prenoms' => $requerant->getPrenoms(),
                'sexe' => $requerant->getSexe(),
                'telephone' => $requerant->getTelephone(),
                'adresse' => $requerant->getAdresse(),
                'localite' => $requerant->getLocalite()->getId(),
            ];
        }

        $js = new JsonResponse($data);
        $js->headers->set("X-Content-Type-Options", "nosniff");
        $js->headers->set("Access-Control-Allow-Headers", ["Authorization, Content-Disposition, Content-MD5, Content-Type"]);
        return $js;
    }

    #[Route(path: '/defendeur/{telephone}', name: 'ajax_defendeur_telephone')]
    public function findDefendeurByTelephone(Defendeur $requerant)
    {


        $data = [];
        if ($requerant) {
            $data = [
                'id' => $requerant->getId(),
                'email' => $requerant->getEmail(),
                'nom' => $requerant->getNom(),
                'prenoms' => $requerant->getPrenoms(),
                'sexe' => $requerant->getSexe(),
                'telephone' => $requerant->getTelephone(),
                'adresse' => $requerant->getAdresse(),
                'localite' => $requerant->getLocalite()->getId(),
            ];
        }

        $js = new JsonResponse($data);
        $js->headers->set("X-Content-Type-Options", "nosniff");
        $js->headers->set("Access-Control-Allow-Headers", ["Authorization, Content-Disposition, Content-MD5, Content-Type"]);
        return $js;
    }


    #[Route(path: '/localite/{type}/{id}', name: 'ajax_filtre_quartier')]
    public function index(Request $request, CommuneRepository $communeRepository, ArrondissementRepository $arrondissementRepository,UserRepository $userRepository ,SectionRepository $sectionRepository): Response
    {
         $em =  $this->entityManager;

        $type = $request->get('type');
        $id = $request->get('id');
        if ($type === 'commune') {
            $Resultat = $communeRepository->findBy(['departement' => $id]);
            //  $foreign = 'region_id';
        } else if ($type === 'arrondissement') {
            $Resultat = $arrondissementRepository->findBy(['commune' => $id]);
            //  $foreign =  'department_id';
        } else if ($type === 'quartier') {
            $Resultat =  $this->entityManager->getRepository('App:Quartier')->findBy(['arrondissement' => $id]);
            //  $foreign =  'department_id';
        } else if ($type === 'vente') {
            // throw new Exception('Unknown type ' . $type);
            if ($id == 1) {
                $Resultat = $em->getRepository('App:ProprieteType')->findBy(['type' => $id]);
            } else {
                $Resultat = $em->getRepository('App:ProprieteType')->findAll();
            }

        } else if ($type === 'structure') {
            $Resultat = $sectionRepository->findBy(['structure' => $id]);
        }

        else if ($type === 'section') {

            $Resultat = $userRepository->findBy(['sections' => $id,'titre'=>"CONSEILLER"]);
          //  dd( $Resultat );
        }
        else{
            $Resultat = null;
        }
//        if($Resultat) section
//        {
//            $response = array("success" => true,
//            // "code"=>$code,
//           // 'prix'=>$produit->getPrix(),
//           // 'label' => $Resultat->getLibelle(),
//            'value' => $Resultat['id']
//
//             );
//        }
        $data = [];
        foreach ($Resultat as $item) {
            if ($type === 'section') {
                $label = $item->getFullName();
            } else {
                if ($item->getLibelle()) {
                    $label = $item->getLibelle();
                } else {
                    $label = $item->getName();
                }
            }

            $data[] = [

                'label' => $label,
                'value' => $item->getId(),

            ];

        }
        // dd($type,$id,$Resultat,$data);

        return new Response(json_encode($data));
        // return json_encode($Resultat);

        dd($type, $id, $Resultat);
        return $this->render('ajax/index.html.twig', [
            'controller_name' => 'AjaxController',
        ]);
    }


    #[Route(path: '/path-to-fetch-conseillers-and-greffiers/{sectionId}', name: 'fetch_conseillers_and_greffiers')]
    public function fetchConseillersAndGreffiers($sectionId, EntityManagerInterface $em,UserRepository $userRepository)
    {
        $section = $em->getRepository(Section::class)->find($sectionId);

        if (!$section) {
            throw $this->createNotFoundException('Section not found');
        }

        $conseillers = $userRepository->findBy(['sections' =>$section,'titre'=>"CONSEILLER"]);;
        $greffiers = $userRepository->findBy(['sections' => $section,'titre'=>"GREFFIER"]);;

        $response = [
            'conseillers' => [],
            'greffiers' => []
        ];

        foreach ($conseillers as $conseiller) {
            $response['conseillers'][] = [
                'id' => $conseiller->getId(),
                'name' => $conseiller->getFullName(),
            ];
        }

        foreach ($greffiers as $greffier) {
            $response['greffiers'][] = [
                'id' => $greffier->getId(),
                'name' => $greffier->getFullName(),
            ];
        }

        return new JsonResponse($response);
    }
}
