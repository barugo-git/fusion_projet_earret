<?php

namespace App\Controller;

use App\Entity\Instructions;
use App\Form\InstructionsType;
use App\Repository\InstructionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/instructions')]
final class InstructionsController extends AbstractController
{
    private function checkAccess(): void
    {
        if (!$this->isGranted('ROLE_SUPER_ADMIN') && !$this->isGranted('ROLE_CONSEILLER')) {
            throw $this->createAccessDeniedException('Accès non autorisé.');
        }
    }

    #[Route(name: 'app_instructions_index', methods: ['GET'])]
    public function index(InstructionsRepository $instructionsRepository): Response
    {
        $this->checkAccess();

        return $this->render('instructions/index.html.twig', [
            'instructions' => $instructionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_instructions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->checkAccess();

        $instruction = new Instructions();
        $form = $this->createForm(InstructionsType::class, $instruction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($instruction);
            $entityManager->flush();

            return $this->redirectToRoute('app_instructions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('instructions/new.html.twig', [
            'instruction' => $instruction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_instructions_show', methods: ['GET'])]
    public function show(Instructions $instruction): Response
    {
        $this->checkAccess();

        return $this->render('instructions/show.html.twig', [
            'instruction' => $instruction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_instructions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Instructions $instruction, EntityManagerInterface $entityManager): Response
    {
        $this->checkAccess();

        $form = $this->createForm(InstructionsType::class, $instruction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_instructions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('instructions/edit.html.twig', [
            'instruction' => $instruction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_instructions_delete', methods: ['POST'])]
    public function delete(Request $request, Instructions $instruction, EntityManagerInterface $entityManager): Response
    {
        $this->checkAccess();

        if ($this->isCsrfTokenValid('delete' . $instruction->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($instruction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_instructions_index', [], Response::HTTP_SEE_OTHER);
    }
}
