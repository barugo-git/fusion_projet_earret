<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Form\ObjetType;
use App\Repository\ObjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/objet')]
#[IsGranted('ROLE_SUPER_ADMIN')]
class ObjetController extends AbstractController
{
    #[Route(path: '/', name: 'app_admin_objet_index')]
    public function index(ObjetRepository $objetRepository,Request $request): Response
    {
//        $objet = new Objet();
//        $form = $this->createForm(ObjetType::class, $objet);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $objetRepository->add($objet, true);
//
//            return $this->redirectToRoute('app_admin_objet_index', [], Response::HTTP_SEE_OTHER);
//        }
        return $this->render('objet/index-objet1.html.twig', [
            'objets' => $objetRepository->findAll(),
            'pagetitle'=>'Liste',
            'title'=>'Objets',
           // 'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/new', name: 'app_objet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ObjetRepository $objetRepository): Response
    {
        $objet = new Objet();
        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objetRepository->add($objet, true);
            $this->addFlash('success', 'Objet enregistré  avec succès.');



            return $this->redirectToRoute('app_admin_objet_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('objet/new-objet1.html.twig', [
            'objet' => $objet,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'app_objet_show', methods: ['GET'])]
    public function show(Objet $objet): Response
    {
        return $this->render('objet/show.html.twig', [
            'objet' => $objet,
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'app_objet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Objet $objet, ObjetRepository $objetRepository): Response
    {
        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objetRepository->add($objet, true);
            $this->addFlash('success', 'Objet modifié  avec succès.');

            return $this->redirectToRoute('app_admin_objet_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('objet/edit-objet.html.twig', [
            'objet' => $objet,
            'form' => $form,
            'pagetitle' => 'Liste',
            'title' => 'Objets',
        ]);
    }

    #[Route(path: '/{id}', name: 'app_objet_delete', methods: ['POST'])]
    public function delete(Request $request, Objet $objet, ObjetRepository $objetRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$objet->getId(), $request->request->get('_token'))) {
            $objetRepository->remove($objet, true);
        }

        return $this->redirectToRoute('app_objet_index', [], Response::HTTP_SEE_OTHER);
    }
}
