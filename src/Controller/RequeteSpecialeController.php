<?php

namespace App\Controller;

use App\Entity\Dossier;
use App\Form\DossierSpecialType;
use App\Form\DossierType;
use App\Repository\ArrondissementRepository;
use App\Repository\DefendeurRepository;
use App\Repository\DossierRepository;
use App\Repository\RequerantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_GREFFIER','ROLE_GREFFIER_EN_CHEF')]
class RequeteSpecialeController extends AbstractController
{

    /// greffier en chef
    #[Route(path: '/requete-speciale', name: 'app_requete_speciale_new')]
    public function new(Request $request, DossierRepository $dossierRepository, ArrondissementRepository $arrondissementRepository, DefendeurRepository $defendeurRepository
        , RequerantRepository $requerantRepository): Response
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
