<?php

namespace App\Controller;

use App\Entity\Audience;
use App\Entity\Dossier;
use App\Form\AudienceType;
use App\Repository\AudienceRepository;
use App\Repository\DossierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/audience')]
#[IsGranted('ROLE_GREFFIER','ROLE_GREFFIER_EN_CHEF')]
class AudienceController extends AbstractController
{
    #[Route(path: '/', name: 'app_audience_index', methods: ['GET'])]
    public function index(AudienceRepository $audienceRepository,DossierRepository $dossierRepository): Response
    {


        return $this->render('audience/index.html.twig', [
            'audiences' => $audienceRepository->findAll(),
        ]);
    }

    #[Route(path: '/new', name: 'app_audience_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AudienceRepository $audienceRepository): Response
    {

        // Récupérer l'utilisateur connecté
        $user = $this->getUser();


        $audience = new Audience();
        $form = $this->createForm(AudienceType::class, $audience,['user' => $user]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossiers = $form->get('dossiers')->getData();
            foreach ($dossiers as $dossier ){
                $dossier->addAudience($audience);
            }

            $audienceRepository->add($audience, true);

            return $this->redirectToRoute('app_audience_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('audience/new.html.twig', [
            'audience' => $audience,
            'form' => $form,
        ]);
    }

    #[Route(path: '/audience-programme/{id}', name: 'greffier_audience_programme', methods: ['GET', 'POST'])]
    public function audienceProgramme(Audience $audience): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('dossier/audience_programme.html.twig', [
            'audience' => $audience,
        ]);
    }

    #[Route(path: '/avis-audience/dossier/{id}', name: 'avis_audience_dossier_programme', methods: ['GET', 'POST'])]
    public function avisAudienceDossier(Dossier $dossier): \Symfony\Component\HttpFoundation\Response{

        return $this->render('audience/audience_dossier_programme.html.twig',[
            'dossier'=>$dossier,
        ]);

    }

    #[Route(path: '/{id}', name: 'app_audience_show', methods: ['GET'])]
    public function show(Audience $audience): Response
    {
        return $this->render('audience/show.html.twig', [
            'audience' => $audience,
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'app_audience_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Audience $audience, AudienceRepository $audienceRepository): Response
    {
        $form = $this->createForm(AudienceType::class, $audience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $audienceRepository->add($audience, true);

            return $this->redirectToRoute('app_audience_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('audience/edit.html.twig', [
            'audience' => $audience,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'app_audience_delete', methods: ['POST'])]
    public function delete(Request $request, Audience $audience, AudienceRepository $audienceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$audience->getId(), $request->request->get('_token'))) {
            $audienceRepository->remove($audience, true);
        }

        return $this->redirectToRoute('app_audience_index', [], Response::HTTP_SEE_OTHER);
    }
}
