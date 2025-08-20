<?php
// src/Controller/ModeleRapportController.php
namespace App\Controller;

use App\Entity\ModeleRapport;
use App\Entity\Section;
use App\Entity\Structure;
use App\Entity\Rapport;
use App\Repository\SectionRepository;
use App\Repository\RapportRepositoryRepository;
use App\Form\ModeleRapportType;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/modele/rapport')]
class ModeleRapportController extends AbstractController
{
    #[Route('/', name: 'app_modele_rapport_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $modeleRapports = $em->getRepository(ModeleRapport::class)->findAll();
        return $this->render('modele/index.html.twig', [
            'modele_rapports' => $modeleRapports,
        ]);
    }

    #[Route('/new', name: 'app_modele_rapport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, FileUploader $fileUploader): Response
    {
        $modele = new ModeleRapport();
        $modele->setCreatedAt(new DateTimeImmutable());
        $form = $this->createForm(ModeleRapportType::class, $modele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier unicité par structure, section et type de rapport
            $existing = $em->getRepository(ModeleRapport::class)->count([
                'structure' => $modele->getStructure(),
                'section' => $modele->getSection(),
                'typeRapport' => $modele->getTypeRapport()
            ]);

            if ($existing > 0) {
                $this->addFlash('error', 'Un modèle pour cette structure, cette section et ce type de rapport existe déjà.');
                return $this->redirectToRoute('app_modele_rapport_new');
            }

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('fichier')->getData();
            if ($file) {
                $fileName = $fileUploader->upload($file, 'models'); // Utiliser le sous-dossier "models"
                $modele->setFichier($fileName);
            }

            $em->persist($modele);
            $em->flush();
            $this->addFlash('success', 'Modèle de rapport enregistré avec succès.');
            return $this->redirectToRoute('app_modele_rapport_index');
        }

        return $this->render('modele/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/sections/{structureId}', name: 'get_sections', methods: ['GET'])]
    public function getSections(SectionRepository $sectionRepository, string $structureId): JsonResponse
    {
        $sections = $sectionRepository->findBy(['structure' => $structureId]);

        $data = array_map(fn(Section $section) => [
            'id' => $section->getId(),
            'name' => $section->getName(),
        ], $sections);

        return $this->json($data);
    }

    #[Route('/convert-pdf/{id}', name: 'modele_rapport_convert_pdf', methods: ['GET'])]
    public function convertToPdf(ModeleRapport $modele): Response
    {
        $filePath = $this->getParameter('upload_directory') . '/' . $modele->getFichier();

        if (!file_exists($filePath)) {
            $this->addFlash('error', 'Le fichier du modèle n\'existe pas ou a été supprimé.');
            return $this->redirectToRoute('app_modele_rapport_show', ['id' => $modele->getId()]);
        }

        // Lire le contenu du fichier .docx avec PhpWord
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);

        // Convertir le contenu en HTML
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        ob_start();
        $htmlWriter->save('php://output');
        $htmlContent = ob_get_clean();

        // Utiliser Dompdf pour convertir le HTML en PDF
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($htmlContent);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Retourner le PDF comme réponse
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="modele_rapport_' . $modele->getId() . '.pdf"',
        ]);
    }

    #[Route('/{id}', name: 'app_modele_rapport_show', methods: ['GET'])]
    public function show(ModeleRapport $modele): Response
    {
        return $this->render('modele/show.html.twig', [
            'modele' => $modele,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_modele_rapport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ModeleRapport $modele, EntityManagerInterface $em, FileUploader $fileUploader): Response
    {
        $ancienFichier = $modele->getFichier(); // Conserver l'ancien fichier
        $modele->setUpdateAt(new DateTimeImmutable());
        $form = $this->createForm(ModeleRapportType::class, $modele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('fichier')->getData();
            if ($file) {
                // Uploader le nouveau fichier
                $fileName = $fileUploader->upload($file, 'models');
                if ($ancienFichier) {
                    // Supprimer l'ancien fichier
                    $fileUploader->removeFile($ancienFichier);
                }
                $modele->setFichier($fileName);
            } else {
                // Conserver l'ancien fichier si aucun nouveau fichier n'est sélectionné
                $modele->setFichier($ancienFichier);
            }

            $em->flush();
            $this->addFlash('success', 'Modèle de rapport mis à jour avec succès.');
            return $this->redirectToRoute('app_modele_rapport_index');
        }

        return $this->render('modele/edit.html.twig', [
            'modele' => $modele,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_modele_rapport_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        ModeleRapport $modele,
        EntityManagerInterface $em,
        FileUploader $fileUploader
    ): Response {
        // Vérifier le token CSRF
        if (!$this->isCsrfTokenValid('delete' . $modele->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_modele_rapport_index');
        }

        // Vérifier si le modèle est lié à un rapport
        $rapports = $em->getRepository(Rapport::class)->findBy(['modeleRapport' => $modele]);
        if (count($rapports) > 0) {
            $this->addFlash('error', 'Impossible de supprimer ce modèle : il est déjà lié à un ou plusieurs rapports.');
            return $this->redirectToRoute('app_modele_rapport_index');
        }

        // Supprimer le fichier associé s'il existe
        if ($modele->getFichier()) {
            $fileUploader->removeFile($modele->getFichier());
        }

        // Supprimer le modèle
        $em->remove($modele);
        $em->flush();

        $this->addFlash('success', 'Modèle de rapport supprimé avec succès.');
        return $this->redirectToRoute('app_modele_rapport_index');
    }
}
