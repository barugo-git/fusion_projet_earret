<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Dossier;
use App\Entity\User;
use App\Form\DossierEditType;
use App\Form\DossierRequerantEditType;
use App\Form\DossierRequerantType;
use App\Repository\ArrondissementRepository;
use App\Repository\DossierRepository;
use App\Repository\PartieRepository;
use App\Repository\RepresentantRepository;
use App\Service\CodeGenerator;
use App\Service\FileUploader;
use App\Service\MailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_GREFFIER") or is_granted("ROLE_GREFFIER_EN_CHEF") or is_granted("ROLE_BUREAU_ORIENTATION")'))]

#[Route(path: '/bureau-orientation')]
class BureauOrientationController extends AbstractController
{
    #[Route(path: '/demandes-en-ligne', name: 'greffier_demande_ligne')]
    public function demandeEnLigne( #[CurrentUser] User    $user, DossierRepository $dossierRepository): Response
    {
        return $this->render('dossier/index.html.twig', [
            'dossiers' => $dossierRepository->findBy([
                'etatDossier' => 'NOUVEAU',

//                'createdBy'=>$this->getUser(),
//                'structure'=>$this->getUser()->getStructure()
            ],
                [
                    'dateEnregistrement' => 'DESC',
                ]),
        ]);
    }

    #[Route(path: 'demande/validation/{id}', name: 'greffier_valide_demande')]
    public function validationDemande( #[CurrentUser] User    $user,Dossier $dossier, DossierRepository $dossierRepository, MailService $mailService): Response
    {
        $dossier->setCreatedBy($this->getUser());
        $dossier->setEtatDossier('RECOURS');
        $dossierRepository->add($dossier, true);
        $this->addFlash('success', 'La réquete a été validée avec success');
        if ($dossier->getRequerant()->getEmail()) {
            $mail = $dossier->getRequerant()->getEmail();
            $sujet = 'Votre recours a été bien validé avec succes';

            $context =[
                'requerent'=>$dossier->getRequerant()->getPrenoms().' '.$dossier->getRequerant()->getNom(),
                'codeSuivi'=> $dossier->getCodeSuivi(),
            ];

            $mailService->sendEmail($mail,$sujet,'notification_valide.html.twig',$context);

        }
        return $this->redirectToRoute('admin_dossier_details', ['id'=>$dossier->getId()], Response::HTTP_SEE_OTHER);

    }

    #[Route(path: 'demande/rejet/{id}', name: 'greffier_rejet_demande')]
    public function rejetDemande( #[CurrentUser] User    $user,Dossier $dossier, DossierRepository $dossierRepository, MailService $mailService): Response
    {
        $dossier->setCreatedBy($this->getUser());
        $dossier->setEtatDossier('REJET');
        $dossierRepository->add($dossier, true);
        $this->addFlash('success', 'La réquete a été rejete');
        if ($dossier->getRequerant()->getEmail()) {
            $mail = $dossier->getRequerant()->getEmail();
            $sujet = 'Votre recours a été bien rejeté';

            $context =[
                'requerent'=>$dossier->getRequerant()->getPrenoms().' '.$dossier->getRequerant()->getNom(),
            ];

            $mailService->sendEmail($mail,$sujet,'notification_refus.html.twig',$context);

        }
        return $this->redirectToRoute('admin_dossier_details', ['id'=>$dossier->getId()], Response::HTTP_SEE_OTHER);

    }

    #[Route(path: '/editer-requete/{id}', name: 'greffier_demande_edit_recours')]
    public function modifierRecours(Dossier $dossier, Request $request, DossierRepository $dossierRepository, FileUploader $fileUploader, CodeGenerator $codeGenerator, MailService $mailService
    )
    {

        $form = $this->createForm(DossierEditType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossierRepository->add($dossier, true);
            $this->addFlash('success', 'La réquete a été modifiée avec success');
            return $this->redirectToRoute('admin_dossier_details', ['id'=>$dossier->getId()], Response::HTTP_SEE_OTHER);

        }

        return $this->render('dossier/new_dossier.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }


    #[Route(path: '/editer-requerant/{id}', name: 'greffier_demande_edit_requerant')]
    public function modifierRequerant(Dossier $dossier, Request $request, DossierRepository $dossierRepository, ArrondissementRepository $arrondissementRepository, RepresentantRepository $representantRepository
        , PartieRepository  $requerantRepository)
    {


        $form = $this->createForm(DossierRequerantEditType::class, $dossier, ['action' => $this->generateUrl('front_requerant')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $dossierRepository->add($dossier, true);
//            $session->set('_dossier', $dossier->getId());
            return $this->redirectToRoute('defendeur', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('dossier/new_dossier_requerant.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);

    }


}
