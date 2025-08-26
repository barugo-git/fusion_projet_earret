<?php
// src/Controller/RapportController.php

namespace App\Controller;

use App\Entity\Rapport;
use App\Entity\Dossier;
use App\Entity\User;
use App\Entity\ModeleRapport;
use App\Repository\RapportRepository;
use App\Repository\ModeleRapportRepository;
use Smalot\PdfParser\Parser;
use App\Form\RapportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormError;
use DateTimeImmutable;
use PhpOffice\PhpWord\TemplateProcessor;

#[Route('/rapport')]
class RapportController extends AbstractController
{
    private $logger;
    private $uploadDirectory;
    private $rapportsDirectory;

    public function __construct(
        LoggerInterface $logger,
        string $uploadDirectory,
        string $rapportsDirectory
    ) {
        $this->logger = $logger;
        $this->uploadDirectory = rtrim($uploadDirectory, '/\\');
        $this->rapportsDirectory = rtrim($rapportsDirectory, '/\\');

        if (!file_exists($this->uploadDirectory)) {
            mkdir($this->uploadDirectory, 0777, true);
        }
        if (!file_exists($this->rapportsDirectory)) {
            mkdir($this->rapportsDirectory, 0777, true);
        }
    }

    #[Route('/', name: 'rapport_index', methods: ['GET'])]
    public function index(
        Request $request,
        RapportRepository $rapportRepository,
        ModeleRapportRepository $modeleRapportRepository
    ): Response {
        $user = $this->getUser();
        $dateFilter = $request->query->get('date_filter', 'all');
        $typeFilter = $request->query->get('type_rapport', 'all');

        // Vérification des rôles
        if (!array_intersect(['ROLE_PCS', 'ROLE_PCJ', 'ROLE_PCA', 'ROLE_CONSEILLER'], $user->getRoles())) {
            throw $this->createAccessDeniedException('Accès non autorisé');
        }

        // Définir les libellés des périodes
        $periodLabels = [
            '1h' => '1 heure',
            '24h' => '24 heures',
            '7j' => '7 jours',
            '14j' => '14 jours',
            '30j' => '30 jours',
            '3m' => '3 mois',
            '6m' => '6 mois',
            '1y' => '1 an',
            '2y' => '2 ans',
            'all' => 'Toutes périodes'
        ];

        // Construction des filtres
        $filters = [];

        if ($typeFilter !== 'all') {
            $filters['type'] = $typeFilter;
        }

        if (in_array('ROLE_CONSEILLER', $user->getRoles())) {
            $filters['user'] = $user->getUserIdentifier();
        } elseif (in_array('ROLE_PCJ', $user->getRoles())) {
            $filters['structure'] = 'Chambre Judiciaire';
        } elseif (in_array('ROLE_PCA', $user->getRoles())) {
            $filters['structure'] = 'Chambre Administrative';
        }

        // Gestion de la date
        $startDate = ($dateFilter !== 'all') ? $this->getStartDate($dateFilter) : null;

        // Récupération des données
        $rapports = $rapportRepository->findWithFilters($filters, $startDate);
        $types = $rapportRepository->findDistinctTypes();

        // Préparation des statistiques
        $stats = $this->prepareStats($rapportRepository, $filters, $user);

        // Détermination du type de graphique et des données
        $chartData = [];
        $chartType = 'bar'; // Par défaut

        if ($typeFilter === 'all' && $dateFilter === 'all') {
            // Cas 1: Tous types + Toutes périodes - Pie chart des types
            $typesDistribution = $rapportRepository->getTypesDistribution($filters);
            $chartType = 'pie';
            $chartData = [
                'labels' => array_keys($typesDistribution),
                'data' => array_values($typesDistribution),
                'backgroundColor' => $this->generateChartColors(count($typesDistribution))
            ];
        } elseif ($typeFilter !== 'all' && $dateFilter === 'all') {
            // Cas 2: Type spécifique + Toutes périodes - Un seul chiffre
            $chartType = 'doughnut';
            $chartData = [
                'labels' => [$typeFilter],
                'data' => [count($rapports)],
                'backgroundColor' => ['#4361ee']
            ];
        } elseif ($typeFilter !== 'all' && $dateFilter !== 'all') {
            // Cas 4: Type spécifique + Période spécifique - Bar chart des rapports par sous-périodes
            $periodStats = [];

            foreach ($periodLabels as $periodKey => $label) {
                if ($periodKey === 'all') continue;

                $periodStartDate = $this->getStartDate($periodKey);
                $periodStats[$periodKey] = $rapportRepository->countByFilters(
                    array_merge($filters, ['type' => $typeFilter]),
                    $periodStartDate
                );
            }

            $chartData = [
                'labels' => array_values(array_slice($periodLabels, 0, -1)), // Exclure 'all'
                'data' => array_values($periodStats),
                'backgroundColor' => '#4361ee'
            ];
        } else {
            // Cas 3: Type all + Période spécifique - Bar chart des périodes
            $chartData = [
                'labels' => array_values($periodLabels),
                'data' => array_values($stats),
                'backgroundColor' => '#4361ee'
            ];
        }

        $isPieChart = ($typeFilter === 'all' && $dateFilter === 'all') || ($typeFilter !== 'all' && $dateFilter === 'all');

        return $this->render('rapport/index.html.twig', [
            'rapports' => $rapports,
            'types' => $types,
            'stats' => $stats,
            'is_pie_chart' => $isPieChart,
            'chart_data' => $chartData,
            'chart_type' => $chartType,
            'current_filter' => $dateFilter,
            'current_type' => $typeFilter,
            'total' => count($rapports),
            'period_labels' => $periodLabels,
            'show_period_stats' => !($typeFilter !== 'all' && $dateFilter === 'all')
        ]);
    }

    private function generateChartColors(int $count): array
    {
        $colors = [];
        for ($i = 0; $i < $count; $i++) {
            $hue = ($i * 360 / $count) % 360;
            $colors[] = "hsl($hue, 70%, 60%)";
        }
        return $colors;
    }

    private function prepareStats(RapportRepository $repo, array $filters, User $user): array
    {
        $periods = [
            '1h' => '-1 hour',
            '24h' => '-1 day',
            '7j' => '-7 days',
            '14j' => '-14 days',
            '30j' => '-30 days',
            '3m' => '-3 months',
            '6m' => '-6 months',
            '1y' => '-1 year',
            '2y' => '-2 years'
        ];

        $stats = [];
        foreach ($periods as $key => $interval) {
            $date = new \DateTime($interval);
            $stats[$key] = $repo->countByFilters($filters, $date);
        }

        return $stats;
    }

    private function getStartDate(string $filter): \DateTime
    {
        $intervals = [
            '1h' => '-1 hour',
            '24h' => '-1 day',
            '7j' => '-7 days',
            '14j' => '-14 days',
            '30j' => '-30 days',
            '3m' => '-3 months',
            '6m' => '-6 months',
            '1y' => '-1 year',
            '2y' => '-2 years'
        ];

        if (!isset($intervals[$filter])) {
            throw new \InvalidArgumentException('Période invalide: ' . $filter);
        }

        return new \DateTime($intervals[$filter]);
    }

    #[Route('/{id}', name: 'rapport_show', methods: ['GET'])]
    public function show(Rapport $rapport): Response
    {
        $moyens = [];
        if ($rapport->getTypeRapport() === Rapport::TYPE_FOND) {
            $moyens = $this->prepareMoyensForDisplay($rapport->getDonnees());
        }

        return $this->render('rapport/show.html.twig', [
            'rapport' => $rapport,
            'moyens' => $moyens
        ]);
    }

    #[Route('/convert-pdf/{referenceDossier}', name: 'rapport_convert_pdf', methods: ['GET'], requirements: ['referenceDossier' => '.+'])]
    public function convertToPdf(string $referenceDossier, EntityManagerInterface $em): Response
    {
        $dossier = $em->getRepository(Dossier::class)->findOneBy(['referenceDossier' => $referenceDossier]);

        if (!$dossier) {
            $this->addFlash('error', 'Aucun dossier trouvé avec cette référence.');
            return $this->redirectToRoute('rapport_index');
        }

        $rapport = $em->getRepository(Rapport::class)->findOneBy(['dossier' => $dossier]);

        if (!$rapport) {
            $this->addFlash('error', 'Aucun rapport trouvé pour ce dossier.');
            return $this->redirectToRoute('rapport_index');
        }

        $filePath = $this->rapportsDirectory . '/' . $rapport->getFichier();

        if (!file_exists($filePath)) {
            $this->addFlash('error', 'Le fichier du rapport n\'existe pas.');
            return $this->redirectToRoute('rapport_show', ['id' => $rapport->getId()]);
        }

        try {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);
            $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
            ob_start();
            $htmlWriter->save('php://output');
            $htmlContent = ob_get_clean();

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($htmlContent);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Génération du nom de fichier sécurisé
            $safeReference = preg_replace('/[^a-zA-Z0-9_-]/', '_', $dossier->getReferenceDossier());
            $nomRequerant = $dossier->getRequerant() ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $dossier->getRequerant()->getNomComplet()) : 'Inconnu';
            $nomDefendeur = $dossier->getDefendeur() ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $dossier->getDefendeur()->getNomComplet()) : 'Inconnu';

            $pdfFilename = sprintf('Rapport_%s_%s_vs_%s.pdf', $safeReference, $nomRequerant, $nomDefendeur);

            return new Response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $pdfFilename . '"',
            ]);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de la génération du PDF.');
            return $this->redirectToRoute('rapport_show', ['id' => $rapport->getId()]);
        }
    }

    #[Route('/download/{id}', name: 'rapport_download', methods: ['GET'])]
    public function download(Rapport $rapport): Response
    {
        $filePath = $this->rapportsDirectory . '/' . $rapport->getFichier();

        if (!file_exists($filePath)) {
            $this->addFlash('error', 'Le fichier du rapport n\'existe pas ou a été supprimé.');
            return $this->redirectToRoute('rapport_show', ['id' => $rapport->getId()]);
        }

        // Construire le nom du fichier pour le téléchargement
        $dossier = $rapport->getDossier();
        $safeReferenceDossier = preg_replace('/[\/\\\\]/', '_', $dossier->getReferenceDossier());
        $safeNomRequerant = preg_replace('/[\/\\\\]/', '_', $dossier->getRequerant()->getNom());
        $safeNomDefendeur = preg_replace('/[\/\\\\]/', '_', $dossier->getDefendeur()->getNom());
        $downloadFilename = sprintf(
            'Dossier %s %s et %s.docx',
            $safeReferenceDossier,
            $safeNomRequerant,
            $safeNomDefendeur
        );

        $response = new BinaryFileResponse($filePath);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $downloadFilename
        );

        return $response;
    }

    private function extraireMoyensDepuisPdf(string $pdfPath): array
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($pdfPath);
            $text = $pdf->getText();

            // Nettoyage basique
            $text = str_replace("\r", "\n", $text);
            $text = preg_replace('/\n+/', "\n", $text);

            // Trouver la partie utile
            $startPos = strpos($text, 'L\'arrêt entrepris encourt cassation pour les moyens suivants :');
            if ($startPos === false) {
                $startPos = strpos($text, 'Moyens de cassation :');
            }

            $endPos = strpos($text, 'SOUS TOUTES RESERVES.', $startPos);

            if ($startPos === false || $endPos === false) {
                throw new \Exception("Impossible de localiser la section des moyens dans le PDF");
            }

            $moyensEtMotifsText = substr($text, $startPos, $endPos - $startPos);

            // Chercher "PAR CES MOTIFS"
            $motifsPos = strpos($moyensEtMotifsText, 'PAR CES MOTIFS');
            if ($motifsPos === false) {
                $moyensText = $moyensEtMotifsText;
                $motifsText = '';
            } else {
                $moyensText = trim(substr($moyensEtMotifsText, 0, $motifsPos));
                $motifsText = trim(substr($moyensEtMotifsText, $motifsPos));
            }

            // Découper les moyens
            $pattern = '/(Premier|Deuxième|Troisième|Quatrième|Cinquième|Sixième|Septième|Huitième|Neuvième|Dixième) Moyen de cassation:/i';
            preg_match_all($pattern, $moyensText, $matches, PREG_OFFSET_CAPTURE);

            $moyens = [];
            for ($i = 0; $i < count($matches[0]); $i++) {
                $start = $matches[0][$i][1];
                $end = isset($matches[0][$i + 1][1]) ? $matches[0][$i + 1][1] : strlen($moyensText);
                $moyenTexte = trim(substr($moyensText, $start, $end - $start));
                $moyens[] = $moyenTexte;
            }

            // Ajouter les motifs comme un "dernier moyen" si trouvé
            if (!empty($motifsText)) {
                $moyens[] = $motifsText;
            }

            return $moyens;
        } catch (\Exception $e) {
            $this->logger->error("Échec de l'extraction des moyens: " . $e->getMessage());
            throw new \Exception("! Les moyens n'ont pas pu être extraits automatiquement du mémoire ampliatif");
        }
    }


    #[Route('/generer/{dossierId}', name: 'rapport_generer', methods: ['GET', 'POST'])]
    public function genererRapport(Request $request, string $dossierId, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $dossier = $em->getRepository(Dossier::class)->find($dossierId);

        if (!$user || !$dossier) {
            throw $this->createNotFoundException('Ressource non trouvée');
        }

        $typeRapport = $this->determinerTypeRapport($dossier);


        if (!$typeRapport) {
            throw new \RuntimeException('Impossible de déterminer le type de rapport');
        }

        $session = $request->getSession();
        $fromPreview = $request->query->get('from_preview');
        $previewData = $session->get('rapport_preview_data');

        if ($fromPreview && $previewData && $previewData['dossier_id'] === $dossierId) {
            $modeleRapport = $em->getRepository(ModeleRapport::class)->find($previewData['modele_id']);
            $formData = $previewData['form_data'];
        } else {
            $modeleRapport = $this->trouverModeleRapport($dossier, $em);
            if (!$modeleRapport) {
                throw $this->createNotFoundException('Aucun modèle de rapport trouvé');
            }
            $formData = null;
        }


        $rapport = $em->getRepository(Rapport::class)->findOneBy(['dossier' => $dossier]);
        $isNew = !$rapport;

        if ($isNew) {
            $rapport = (new Rapport())
                ->setDossier($dossier)
                ->setCreatedBy($user)
                ->setCreatedAt(new DateTimeImmutable())
                ->setStatut(Rapport::STATUT_BROUILLON)
                ->setTypeRapport($typeRapport);
        } elseif (!$rapport->getTypeRapport()) {
            $rapport->setTypeRapport($typeRapport);
        }

        if (!$rapport->getTypeRapport()) {
            throw new \RuntimeException('Le type de rapport n\'a pas été défini');
        }

        $rapport->setModeleRapport($modeleRapport);

        $placeholders = $this->extrairePlaceholders($modeleRapport);
        $requiredFields = $this->determinerChampsObligatoires($modeleRapport);
        $initialData = $this->prepareInitialData($rapport, $dossier, $placeholders);

        if ($formData) {
            $initialData = array_merge($initialData, $formData);
        } else {
            if ($rapport->getTypeRapport() === Rapport::TYPE_FOND && $dossier->getUrlMemoireAmpliatif()) {
                try {
                    $pdfPath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $dossier->getUrlMemoireAmpliatif();
                    if (file_exists($pdfPath)) {
                        $moyens = $this->extraireMoyensDepuisPdf($pdfPath);
                        if (!empty($moyens)) {
                            $initialData['moyens'] = $moyens;
                            $this->addFlash('info', 'Les moyens ont été extraits automatiquement du mémoire ampliatif');
                        }
                    } else {
                        $this->addFlash('warning', 'Le fichier PDF du mémoire ampliatif est introuvable');
                    }
                } catch (\Exception $e) {
                    $this->addFlash('warning', $e->getMessage());
                }
            }
        }

        $form = $this->createForm(RapportType::class, $initialData, [
            'placeholders' => $placeholders,
            'field_types' => $this->determinerTypesChamps($modeleRapport),
            'required_fields' => $requiredFields,
            'type_rapport' => $rapport->getTypeRapport()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $action = $request->request->get('action');

            // Validation des champs obligatoires
            $isValid = true;
            foreach ($requiredFields as $field) {
                if (empty($form->get($field)->getData())) {
                    $form->get($field)->addError(new FormError('Ce champ est obligatoire'));
                    $isValid = false;
                }
            }

            // Validation des moyens pour les rapports Fond
            if ($rapport->getTypeRapport() === Rapport::TYPE_FOND) {
                $moyens = $form->has('moyens') ? $form->get('moyens')->getData() : [];
                if (empty($moyens)) {
                    $form->get('moyens')->addError(new FormError('Au moins un moyen doit être ajouté'));
                    $isValid = false;
                }
            }

            if ($isValid && $form->isValid()) {
                $donnees = $this->filterPlaceholderData($form->getData(), $placeholders);

                if ($rapport->getTypeRapport() === Rapport::TYPE_FOND && $form->has('moyens')) {
                    $donnees['moyens'] = $form->get('moyens')->getData();
                }

                $rapport->setDonnees($donnees);

                if ($action === 'preview') {
                    $session->set('rapport_preview_data', [
                        'donnees' => $donnees,
                        'prepared_data' => $this->prepareMoyensData($donnees),
                        'modele_id' => $modeleRapport->getId(),
                        'dossier_id' => $dossierId,
                        'is_new' => $isNew,
                        'rapport_id' => $rapport->getId(),
                        'form_data' => $form->getData(),
                        'type_rapport' => $rapport->getTypeRapport()
                    ]);
                    return $this->redirectToRoute('rapport_preview', ['dossierId' => $dossierId]);
                }

                if ($action === 'save') {
                    try {
                        $this->validateXmlData($donnees);
                        $this->genererFichierRapport($rapport, $modeleRapport, $dossierId);

                        $rapport->setStatut(Rapport::STATUT_FINALISE)
                            ->setUpdateAt(new DateTimeImmutable());

                        $em->persist($rapport);
                        $em->flush();

                        $this->addFlash('success', 'Rapport généré et enregistré avec succès');
                        return $this->redirectToRoute('rapport_show', ['id' => $rapport->getId()]);
                    } catch (\Exception $e) {
                        $this->addFlash('error', 'Erreur lors de la génération du rapport: ' . $e->getMessage());
                        $this->logger->error('Erreur génération rapport: ' . $e->getMessage());
                    }
                }
            }
        }

        return $this->render('rapport/generer.html.twig', [
            'form' => $form->createView(),
            'dossier' => $dossier,
            'rapport' => $rapport,
            'is_new' => $isNew,
            'type_rapport' => $rapport->getTypeRapport()
        ]);
    }

    #[Route('/preview/{dossierId}', name: 'rapport_preview', methods: ['GET'])]
    public function preview(Request $request, string $dossierId, EntityManagerInterface $em): Response
    {
        $session = $request->getSession();
        $previewData = $session->get('rapport_preview_data');

        if (!$previewData || $previewData['dossier_id'] !== $dossierId) {
            $this->addFlash('error', 'Données de prévisualisation non trouvées');
            return $this->redirectToRoute('rapport_generer', ['dossierId' => $dossierId]);
        }

        $dossier = $em->getRepository(Dossier::class)->find($dossierId);
        $modeleRapport = $em->getRepository(ModeleRapport::class)->find($previewData['modele_id']);

        // Préparation des données sans le champ 'moyen'
        $preparedData = $this->prepareTemplateData($previewData['donnees']);

        $moyens = [];
        if ($previewData['type_rapport'] === Rapport::TYPE_FOND && isset($previewData['donnees']['moyens'])) {
            $moyens = $this->prepareMoyensForDisplay($previewData['donnees']);
        }

        return $this->render('rapport/preview.html.twig', [
            'moyens' => $moyens,
            'donnees' => $preparedData,
            'dossier' => $dossier,
            'modele' => $modeleRapport,
            'is_new' => $previewData['is_new'],
            'rapport_id' => $previewData['rapport_id'],
            'dossier_id' => $dossierId,
            'has_moyens' => ($previewData['type_rapport'] === 'Fond' && !empty($previewData['donnees']['moyens']))
        ]);
    }
    #[Route('/save/{dossierId}', name: 'rapport_save', methods: ['POST'])]
    public function save(Request $request, string $dossierId, EntityManagerInterface $em): Response
    {
        $session = $request->getSession();
        $previewData = $session->get('rapport_preview_data');

        if (!$previewData || $previewData['dossier_id'] !== $dossierId) {
            $this->addFlash('error', 'Session expirée, veuillez recommencer');
            return $this->redirectToRoute('rapport_generer', ['dossierId' => $dossierId]);
        }

        try {
            $rapport = $previewData['is_new']
                ? new Rapport()
                : $em->getRepository(Rapport::class)->find($previewData['rapport_id']);

            $modeleRapport = $em->getRepository(ModeleRapport::class)->find($previewData['modele_id']);
            $dossier = $em->getRepository(Dossier::class)->find($dossierId);
            $typeRapport = $this->determinerTypeRapport($dossier);
            $user = $this->getUser();

            if (!$modeleRapport || !$dossier || !$user) {
                throw $this->createNotFoundException('Données du rapport introuvables');
            }

            $this->validateXmlData($previewData['donnees']);

            $rapport
                ->setDossier($dossier)
                ->setModeleRapport($modeleRapport)
                ->setDonnees($previewData['donnees'])
                ->setCreatedBy($user)
                ->setTypeRapport($typeRapport)
                ->setStatut(Rapport::STATUT_FINALISE);

            if ($previewData['is_new']) {
                $rapport->setCreatedAt(new DateTimeImmutable());
            } else {
                $rapport->setUpdateAt(new DateTimeImmutable());
            }

            $this->genererFichierRapport($rapport, $modeleRapport, $dossierId);

            $em->persist($rapport);
            $em->flush();

            $session->remove('rapport_preview_data');
            $this->addFlash('success', 'Rapport enregistré avec succès');

            return $this->redirectToRoute('rapport_show', ['id' => $rapport->getId()]);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage());
            $this->logger->error('Erreur sauvegarde rapport: ' . $e->getMessage());
            return $this->redirectToRoute('rapport_preview', ['dossierId' => $dossierId]);
        }
    }

    private function genererFichierRapport(Rapport $rapport, ModeleRapport $modeleRapport, string $dossierId): void
    {
        $templatePath = $this->uploadDirectory . '/' . $modeleRapport->getFichier();
        $dossier = $rapport->getDossier();

        // Construction du nom de fichier
        $safeReferenceDossier = preg_replace('/[\/\\\\]/', '_', $dossier->getReferenceDossier());
        $safeNomRequerant = preg_replace('/[\/\\\\]/', '_', $dossier->getRequerant()->getNom());
        $safeNomDefendeur = preg_replace('/[\/\\\\]/', '_', $dossier->getDefendeur()->getNom());
        $outputFilename = sprintf(
            'Dossier %s %s et %s.docx',
            $safeReferenceDossier,
            $safeNomRequerant,
            $safeNomDefendeur
        );
        $outputPath = $this->rapportsDirectory . '/' . $outputFilename;

        try {
            $templateProcessor = new TemplateProcessor($templatePath);
            $donnees = $rapport->getDonnees();

            // Traitement spécial pour les moyens
            if ($rapport->getTypeRapport() === Rapport::TYPE_FOND && isset($donnees['moyens'])) {
                $moyensFormatted = array_map(function ($moyen, $index) {
                    return sprintf("%d. %s", $index + 1, $this->cleanValueForWord($moyen));
                }, $donnees['moyens'], array_keys($donnees['moyens']));

                $templateProcessor->setValue('moyens', implode("\n\n", $moyensFormatted));
                unset($donnees['moyens']);
            }

            // Traitement des autres champs
            foreach ($donnees as $key => $value) {
                $templateProcessor->setValue($key, $this->cleanValueForWord($value));
            }

            $templateProcessor->saveAs($outputPath);
            $rapport->setFichier($outputFilename);
        } catch (\Exception $e) {
            if (file_exists($outputPath)) {
                unlink($outputPath);
            }
            throw new \RuntimeException('Erreur génération document: ' . $e->getMessage());
        }
    }

    private function prepareMoyensForDisplay(array $donnees): array
    {
        if (!isset($donnees['moyens'])) {
            return [];
        }

        return array_map(function ($moyen, $index) {
            return [
                'numero' => $index + 1,
                'texte' => $this->cleanValueForWord($moyen)
            ];
        }, $donnees['moyens'], array_keys($donnees['moyens']));
    }

    private function prepareTemplateData(array $data): array
    {
        $preparedData = [];

        foreach ($data as $key => $value) {
            // Traitement spécial pour les moyens
            if ($key === 'moyens' && is_array($value)) {
                // Formatte les moyens numérotés
                $preparedData['moyens'] = array_map(function ($moyen, $index) {
                    return sprintf("%d. %s", $index + 1, $this->cleanValueForWord($moyen));
                }, $value, array_keys($value));
                continue;
            }

            $preparedData[$key] = $this->cleanValueForWord($value);
        }

        return $preparedData;
    }

    private function cleanValueForWord($value): string
    {
        if ($value === null) {
            return '';
        }

        if ($value instanceof \DateTimeInterface) {
            $formatter = new \IntlDateFormatter(
                'fr_FR',
                \IntlDateFormatter::FULL,
                \IntlDateFormatter::NONE,
                null,
                null,
                'd MMMM yyyy'
            );
            return $formatter->format($value);
        }

        if (is_bool($value)) {
            return $value ? 'Oui' : 'Non';
        }

        if (is_array($value)) {
            return implode(', ', array_map([$this, 'cleanValueForWord'], $value));
        }

        $value = (string)$value;
        $value = htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        return str_replace(["\x00", "\x0B"], '', $value);
    }

    private function validateXmlData(array $data): void
    {
        foreach ($data as $key => $value) {
            if (strpos($key, 'date') !== false && $value !== null) {
                if (!($value instanceof \DateTimeInterface)) {
                    throw new \RuntimeException("Le champ $key doit être une date valide");
                }
            }

            if (is_string($value) && !mb_check_encoding($value, 'UTF-8')) {
                throw new \RuntimeException('Encodage de données non valide');
            }

            if (is_string($value) && preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', $value)) {
                throw new \RuntimeException('Caractères de contrôle non autorisés');
            }
        }
    }

    #[Route('/modifier/{id}', name: 'rapport_modifier', methods: ['GET', 'POST'])]
    public function modifier(Request $request, Rapport $rapport, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CONSEILLER');
        $dossier = $rapport->getDossier();
        $ancienFichier = $rapport->getFichier();
        $session = $request->getSession();

        $fromPreview = $request->query->get('from_preview');
        $previewData = $session->get('rapport_preview_data');

        $placeholders = $this->extrairePlaceholders($rapport->getModeleRapport());
        $requiredFields = $this->determinerChampsObligatoires($rapport->getModeleRapport());

        if ($fromPreview && $previewData && $previewData['rapport_id'] == $rapport->getId()) {
            $formData = $previewData['form_data'];
        } else {
            $formData = $this->prepareInitialData($rapport, $dossier, $placeholders);

            if ($rapport->getTypeRapport() === Rapport::TYPE_FOND) {
                $donnees = $rapport->getDonnees();
                if (isset($donnees['moyens'])) {
                    $formData['moyens'] = $donnees['moyens'];
                }
            }
        }

        $form = $this->createForm(RapportType::class, $formData, [
            'placeholders' => $placeholders,
            'field_types' => $this->determinerTypesChamps($rapport->getModeleRapport()),
            'required_fields' => $requiredFields,
            'type_rapport' => $rapport->getTypeRapport(),
            'mode' => 'edit'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $action = $request->request->get('action');

            if ($action === 'cancel') {
                return $this->redirectToRoute('rapport_show', ['id' => $rapport->getId()]);
            }

            // Validation des champs obligatoires
            $isValid = true;
            foreach ($requiredFields as $field) {
                if (empty($form->get($field)->getData())) {
                    $form->get($field)->addError(new FormError('Ce champ est obligatoire'));
                    $isValid = false;
                }
            }

            // Validation des moyens pour les rapports Fond
            if ($rapport->getTypeRapport() === Rapport::TYPE_FOND) {
                $moyens = $form->has('moyens') ? $form->get('moyens')->getData() : [];
                if (empty($moyens)) {
                    $form->get('moyens')->addError(new FormError('Au moins un moyen doit être ajouté'));
                    $isValid = false;
                }
            }

            if ($isValid && $form->isValid()) {
                $donnees = $this->filterPlaceholderData($form->getData(), $placeholders);

                if ($rapport->getTypeRapport() === Rapport::TYPE_FOND && $form->has('moyens')) {
                    $moyens = $form->get('moyens')->getData();
                    if (!empty($moyens)) {
                        $donnees['moyens'] = $moyens;
                    } elseif (isset($rapport->getDonnees()['moyens'])) {
                        $donnees['moyens'] = $rapport->getDonnees()['moyens'];
                    }
                }

                $rapport->setDonnees($donnees);

                if ($action === 'preview') {
                    $session->set('rapport_preview_data', [
                        'donnees' => $donnees,
                        'prepared_data' => $this->prepareTemplateData($donnees),
                        'modele_id' => $rapport->getModeleRapport()->getId(),
                        'dossier_id' => $dossier->getId(),
                        'rapport_id' => $rapport->getId(),
                        'form_data' => $form->getData(),
                        'type_rapport' => $rapport->getTypeRapport()
                    ]);
                    return $this->redirectToRoute('rapport_preview_modifier', ['id' => $rapport->getId()]);
                }

                if ($action === 'save') {
                    try {
                        if ($ancienFichier && file_exists($this->rapportsDirectory . '/' . $ancienFichier)) {
                            unlink($this->rapportsDirectory . '/' . $ancienFichier);
                        }

                        $this->genererFichierRapport($rapport, $rapport->getModeleRapport(), $dossier->getId());

                        $rapport->setUpdateAt(new DateTimeImmutable());
                        $em->flush();

                        $session->remove('rapport_preview_data');
                        $this->addFlash('success', 'Modifications enregistrées avec succès');
                        return $this->redirectToRoute('rapport_show', ['id' => $rapport->getId()]);
                    } catch (\Exception $e) {
                        $this->addFlash('error', 'Erreur lors de la modification : ' . $e->getMessage());
                        $this->logger->error('Erreur modification rapport', [
                            'exception' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                            'rapport_id' => $rapport->getId()
                        ]);
                    }
                }
            }
        }

        return $this->render('rapport/modifier.html.twig', [
            'form' => $form->createView(),
            'rapport' => $rapport,
            'dossier' => $dossier,
            'type_rapport' => $rapport->getTypeRapport(),
            'is_fond' => $rapport->getTypeRapport() === Rapport::TYPE_FOND
        ]);
    }

    #[Route('/preview-modifier/{id}', name: 'rapport_preview_modifier', methods: ['GET', 'POST'])]
    public function previewModifier(Request $request, Rapport $rapport, EntityManagerInterface $em): Response
    {
        $session = $request->getSession();
        $previewData = $session->get('rapport_preview_data');

        if (!$previewData || $previewData['rapport_id'] !== $rapport->getId()) {
            $this->addFlash('error', 'Données de prévisualisation non trouvées');
            return $this->redirectToRoute('rapport_modifier', ['id' => $rapport->getId()]);
        }

        // Préparation des données pour l'affichage
        $preparedData = $this->prepareTemplateData($previewData['donnees']);
        $hasMoyens = ($previewData['type_rapport'] === 'Fond' && !empty($previewData['donnees']['moyens']));
        $moyens = [];
        if ($rapport->getTypeRapport() === Rapport::TYPE_FOND && isset($previewData['donnees']['moyens'])) {
            $moyens = $this->prepareMoyensForDisplay($previewData['donnees']);
        }

        if ($request->isMethod('POST')) {
            try {
                // Récupération des données depuis la session
                $donnees = $previewData['donnees'];
                $modeleRapport = $em->getRepository(ModeleRapport::class)->find($previewData['modele_id']);
                $dossier = $rapport->getDossier();

                // Suppression de l'ancien fichier
                $ancienFichier = $rapport->getFichier();
                if ($ancienFichier && file_exists($this->rapportsDirectory . '/' . $ancienFichier)) {
                    unlink($this->rapportsDirectory . '/' . $ancienFichier);
                }

                // Mise à jour et génération du rapport
                $rapport->setDonnees($donnees);
                $this->genererFichierRapport($rapport, $modeleRapport, $dossier->getId());
                $rapport->setUpdateAt(new DateTimeImmutable());

                $em->flush();
                $session->remove('rapport_preview_data');

                $this->addFlash('success', 'Les modifications ont été enregistrées avec succès');
                return $this->redirectToRoute('rapport_show', ['id' => $rapport->getId()]);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de l\'enregistrement : ' . $e->getMessage());
                $this->logger->error('Erreur enregistrement prévisualisation', [
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        return $this->render('rapport/preview_modifier.html.twig', [
            'moyens' => $moyens,
            'donnees' => $preparedData,
            'rapport' => $rapport,
            'dossier' => $rapport->getDossier(),
            'modele' => $rapport->getModeleRapport(),
            'has_moyens' => $hasMoyens
        ]);
    }

    private function trouverModeleRapport(Dossier $dossier, EntityManagerInterface $em): ?ModeleRapport
    {
        $section = $dossier->getAffecterSection() ? $dossier->getAffecterSection()->getSection() : null;
        $structure = $section ? $section->getStructure() : null;
        $typeRapport = $this->determinerTypeRapport($dossier);

        return $em->getRepository(ModeleRapport::class)->findOneBy([
            'structure' => $structure,
            'section' => $section,
            'typeRapport' => $typeRapport // Ajout du critère de type
        ]);
    }

    private function prepareMoyensData(array $donnees): array
    {
        $preparedData = [];

        foreach ($donnees as $key => $value) {
            if ($key === 'moyens' && is_array($value)) {
                $preparedData['moyens'] = array_map(function ($moyen) {
                    return $this->cleanValueForWord($moyen);
                }, $value);
            } else {
                $preparedData[$key] = $this->cleanValueForWord($value);
            }
        }

        return $preparedData;
    }

    private function determinerTypeRapport(Dossier $dossier): string
    {
        if (!$dossier->isConsignation()) {
            return Rapport::TYPE_DECHEANCE;
        }

        if (!$dossier->isMemoireAmpliatif()) {
            return Rapport::TYPE_FORCLUSION;
        }

        return Rapport::TYPE_FOND;
    }

    private function extrairePlaceholders(ModeleRapport $modeleRapport): array
    {
        $cheminFichier = $this->uploadDirectory . '/' . $modeleRapport->getFichier();

        if (!file_exists($cheminFichier)) {
            throw new \RuntimeException('Le fichier modèle n\'existe pas : ' . $cheminFichier);
        }

        $templateProcessor = new TemplateProcessor($cheminFichier);
        // dd($templateProcessor->getVariables(), $cheminFichier);
        return $templateProcessor->getVariables();
    }

    private function determinerTypesChamps(ModeleRapport $modeleRapport): array
    {
        $types = [];
        $placeholders = $this->extrairePlaceholders($modeleRapport);
        // dd($placeholders);
        foreach ($placeholders as $placeholder) {
            if ($placeholder === 'moyen') {
                continue;
            }

            if ($this->isDateField($placeholder) || $placeholder === 'GenereLe') {
                $types[$placeholder] = 'date';
            } elseif (
                strpos($placeholder, 'annotation') !== false ||
                strpos($placeholder, 'description') !== false ||
                strpos($placeholder, 'motifs') !== false ||
                strpos($placeholder, 'motivation') !== false
            ) {
                $types[$placeholder] = 'textarea';
            } elseif (
                strpos($placeholder, 'statut') !== false ||
                strpos($placeholder, 'juridiction_origine') !== false ||
                strpos($placeholder, 'type') !== false
            ) {
                $types[$placeholder] = [
                    'type' => 'select',
                    'options' => $this->getOptionsForField($placeholder)
                ];
            } elseif (
                strpos($placeholder, 'montant') !== false ||
                strpos($placeholder, 'somme') !== false
            ) {
                $types[$placeholder] = 'number';
            } else {
                $types[$placeholder] = 'text';
            }
        }

        return $types;
    }

    private function determinerChampsObligatoires(ModeleRapport $modeleRapport): array
    {
        // Extraire tous les placeholders du modèle de rapport
        $placeholders = $this->extrairePlaceholders($modeleRapport);

        // Tous les placeholders sont marqués comme obligatoires
        return $placeholders;
    }
    private function getOptionsForField(string $fieldName): array
    {
        switch (strtolower($fieldName)) {
            case 'statut':
                return [
                    'en_cours' => 'En cours',
                    'valide' => 'Validé',
                    'rejete' => 'Rejeté'
                ];
            case 'juridiction_origine':
                return [
                    'criet' => 'CRIET',
                    'cour speciale des affaires fonciers' => 'COUR SPÉCIALE DES AFFAIRES FONCIÈRES',
                    'cour d\'appel de cotonou' => 'COUR D\'APPEL DE COTONOU',
                    'cour d\'appel Abomey' => 'COUR D\'APPEL D\'ABOMEY',
                    'cour d\'appel de parakou' => 'COUR D\'APPEL DE PARAKOU'
                ];
            case 'typedossier':
                return [
                    'ordinaire' => 'ORDINAIRE',
                    'commercial' => 'Commercial'
                ];
            default:
                return [];
        }
    }

    private function isDateField(string $fieldName): bool
    {
        return stripos($fieldName, 'date') !== false;
    }

    private function prepareInitialData(?Rapport $rapport = null, ?Dossier $dossier = null, ?array $placeholders = null): array
    {
        $initialData = [];

        if ($rapport !== null) {
            $donnees = $rapport->getDonnees() ?? [];

            foreach ($donnees as $key => $value) {
                if ($placeholders === null || in_array($key, $placeholders)) {
                    if ($this->isDateField($key)) {
                        $initialData[$key] = $this->normalizeDateValue($value);
                    } else {
                        $initialData[$key] = $this->normalizeFormValue($value);
                    }
                }
            }

            // Gestion des moyens
            if (isset($donnees['moyens'])) {
                $initialData['moyens'] = $donnees['moyens'];
            }

            $dossier = $rapport->getDossier();
        }

        if ($dossier !== null && $placeholders !== null) {
            $dossierData = [
                'dateEnregistrement' => $this->normalizeDateValue($dossier->getDateEnregistrement()),
                'dateConsignation' => $this->normalizeDateValue($dossier->getDateConsignation()),
                'date_affectation' => $this->normalizeDateValue($dossier->getDateConsignation()),
                'nomRequerant' => $dossier->getRequerant()?->getNomComplet() ?? 'Non renseigné',
                'nomDefendeur' => $dossier->getDefendeur()?->getNomComplet() ?? 'Non renseigné',
                'referenceDossier' => $dossier->getReferenceDossier(),
                'codeSuivi' => $dossier->getCodeSuivi(),
                'AvocatRequerant' => $dossier->getRequerant()->getRepresentants(),
                'AvocatDefendeur' => $dossier->getDefendeur()->getRepresentants(),
                'nomRapporteur' => $dossier->getAffecterSection()->getConseillerRapporteur()->getFullName(),
                'chambre_decision' => $dossier->getAffecterSection()->getSection(),
                'GenereLe' => new \DateTimeImmutable(),
            ];

            if ($dossier->getAffecterSection()) {
                $dossierData['section'] = $dossier->getAffecterSection()->getSection()->getName();
            }

            foreach ($dossierData as $key => $value) {
                if (in_array($key, $placeholders)) {
                    $initialData[$key] = $value;
                }
            }
        }

        return $initialData;
    }
    private function normalizeFormValue($value)
    {
        if ($value instanceof \DateTimeInterface) {
            return $value;
        }

        if (is_string($value) && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
            return \DateTimeImmutable::createFromFormat('d/m/Y', $value);
        }

        return $value;
    }


    private function normalizeDateValue($date): ?\DateTimeImmutable
    {
        if ($date === null) {
            return null;
        }

        if ($date instanceof \DateTimeImmutable) {
            return $date;
        }

        if ($date instanceof \DateTime) {
            return \DateTimeImmutable::createFromInterface($date);
        }

        if (is_array($date) && isset($date['date'])) {
            // Si la date est un tableau, essayez de convertir la valeur 'date'
            $parsedDate = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $date['date']);
            if ($parsedDate === false) {
                throw new \InvalidArgumentException('Invalid date format in array. Expected "Y-m-d H:i:s.u".');
            }
            return $parsedDate;
        }

        if (is_string($date)) {
            // Essayer de parser différents formats de date
            $formats = ['Y-m-d H:i:s.u', 'Y-m-d H:i:s', 'Y-m-d', 'd/m/Y'];
            foreach ($formats as $format) {
                $parsedDate = \DateTimeImmutable::createFromFormat($format, $date);
                if ($parsedDate !== false) {
                    return $parsedDate;
                }
            }
        }

        throw new \InvalidArgumentException('Invalid date format. Expected \DateTimeImmutable or valid date string.');
    }

    private function filterPlaceholderData(array $data, array $placeholders): array
    {
        return array_filter($data, function ($key) use ($placeholders) {
            // Exclure 'moyen' et 'moyens' du filtrage standard
            if ($key === 'moyen' || $key === 'moyens') {
                return false;
            }

            return in_array($key, $placeholders) ||
                str_starts_with($key, 'reference') ||
                str_starts_with($key, 'date');
        }, ARRAY_FILTER_USE_KEY);
    }
}
