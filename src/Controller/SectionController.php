<?php

namespace App\Controller;

use App\Entity\Section;
use App\Form\SectionType;
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/section')]
#[IsGranted('ROLE_SUPER_ADMIN')]
class SectionController extends AbstractController
{
    #[Route('/', name: 'app_section_index', methods: ['GET', 'POST'])]

    /**
     * @Route("/", name="app_section_index")
     */
    public function index(Request $request, SectionRepository $sectionRepository): Response
    {
//        $section = new Section();
//        $form = $this->createForm(SectionType::class, $section);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $sectionRepository->add($section, true);
//
//            return $this->redirectToRoute('app_section_index', [], Response::HTTP_SEE_OTHER);
//        }
        return $this->render('section/index-section1.html.twig', [
            'sections' => $sectionRepository->findAll(),
            'pagetitle' => 'Liste',
            'title' => 'Section',
        ]);
    }

    #[Route('/new', name: 'app_section_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SectionRepository $sectionRepository): Response
    {
        $section = new Section();
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sectionRepository->add($section, true);
            $this->addFlash('success', 'Section enregistrée avec succès.');



            return $this->redirectToRoute('app_section_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('section/new-section1.html.twig', [
            'section' => $section,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_section_show', methods: ['GET'])]
    public function show(Section $section): Response
    {
        return $this->render('section/show.html.twig', [
            'section' => $section,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_section_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Section $section, SectionRepository $sectionRepository): Response
    {
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sectionRepository->add($section, true);
            $this->addFlash('success', 'Section modifiée avec succès.');


            return $this->redirectToRoute('app_section_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('section/edit-section.html.twig', [
            'section' => $section,
            'form' => $form,
            'pagetitle' => 'Liste',
            'title' => 'Sections',
        ]);
    }

    #[Route('/{id}', name: 'app_section_delete', methods: ['POST'])]
    public function delete(Request $request, Section $section, SectionRepository $sectionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$section->getId(), $request->request->get('_token'))) {
            $sectionRepository->remove($section, true);
        }

        return $this->redirectToRoute('app_section_index', [], Response::HTTP_SEE_OTHER);
    }
}
