<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Form\StructureType;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/structure')]
#[IsGranted('ROLE_SUPER_ADMIN')]
class StructureController extends AbstractController
{
    #[Route(path: '/', name: 'app_structure_index', methods: ['GET', 'POST'])]
    public function index(Request $request,StructureRepository $structureRepository): Response
    {
//        $structure = new Structure();
//        $form = $this->createForm(StructureType::class, $structure);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $structureRepository->add($structure, true);
//
//            return $this->redirectToRoute('app_structure_index', [], Response::HTTP_SEE_OTHER);
//        }

        return $this->render('structure/index-structure1.html.twig', [
            'structures' => $structureRepository->findAll(),
            'pagetitle' => 'Liste',
            'title' => 'Structure',
            //'structure' => $structure,
//            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/new', name: 'app_structure_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StructureRepository $structureRepository): Response
    {
        $structure = new Structure();
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureRepository->add($structure, true);
            $this->addFlash('success', 'Structure enregistrée  avec succès.');



            return $this->redirectToRoute('app_structure_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('structure/new-structure1.html.twig', [
            'structure' => $structure,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'app_structure_show', methods: ['GET'])]
    public function show(Structure $structure): Response
    {

        return $this->render('structure/show.html.twig', [
            'structure' => $structure,
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'app_structure_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Structure $structure, StructureRepository $structureRepository): Response
    {
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureRepository->add($structure, true);
            $this->addFlash('success', 'Structure modifiée  avec succès.');

            return $this->redirectToRoute('app_structure_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('structure/edit-structure.html.twig', [
            'structure' => $structure,
            'pagetitle' => 'Liste',
            'title' => 'Structures',
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'app_structure_delete', methods: ['POST'])]
    public function delete(Request $request, Structure $structure, StructureRepository $structureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$structure->getId(), $request->request->get('_token'))) {
            $structureRepository->remove($structure, true);
        }

        return $this->redirectToRoute('app_structure_index', [], Response::HTTP_SEE_OTHER);
    }
}
