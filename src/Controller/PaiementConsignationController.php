<?php
// src/Controller/PaiementConsignationController.php
namespace App\Controller;

use App\Entity\Dossier;
use App\Entity\PaiementConsignation;
use App\Form\PaiementConsignationType;
use App\Form\ConsignationDossierType;
use App\Repository\DossierRepository;
use App\Repository\MesuresInstructionsRepository;
use App\Repository\ReponseMesuresInstructionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use App\Service\DossierConverter;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Psr\Log\LoggerInterface;
use App\Service\FileUploader;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\PaiementConsignationRepository;
use App\Service\ExportService;

#[Route('/paiement-consignation')]
class PaiementConsignationController extends AbstractController
{
    private EntityManagerInterface $em;
    private MailerInterface $mailer;
    private LoggerInterface $logger;
    private string $projectDir;
    private PaiementConsignationRepository $paiementConsignationRepository;
    private ExportService $exportService;

    public function __construct(
        EntityManagerInterface $em,
        MailerInterface $mailer,
        LoggerInterface $logger,
        ParameterBagInterface $params,
        PaiementConsignationRepository $paiementConsignationRepository,
        ExportService $exportService
    ) {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->projectDir = $params->get('kernel.project_dir');
        $this->paiementConsignationRepository = $paiementConsignationRepository;
        $this->exportService = $exportService;
    }

    #[Route('/', name: 'paiement_consignation_index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('paiement_consignation/index.html.twig');
    }

    #[Route('/admin/paiements-consignation/export-pdf', name: 'paiement_consignation_admin_export_pdf')]
    public function exportPdf(
        Request $request,
        PaiementConsignationRepository $paiementRepo,
        ParameterBagInterface $params
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_GREFFIER_EN_CHEF');

        $filters = $request->query->all();
        $paiements = $paiementRepo->findWithFilters($filters);

        // Solution 1 : Chemin relatif (recommandé)
        $logoRelativePath = 'uploads/logo.jpg';
        $absolutePath = $this->getParameter('kernel.project_dir') . '/public/' . $logoRelativePath;

        // Solution 2 : Encodage base64 (garanti)
        $logoBase64 = null;
        if (file_exists($absolutePath)) {
            $imageData = file_get_contents($absolutePath);
            $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($imageData);
        } else {
            // Debug : vérifiez le chemin dans les logs
            $this->logger->error("Logo introuvable", ['path' => $absolutePath]);
        }

        $html = $this->renderView('paiement_consignation/admin/export_pdf.html.twig', [
            'paiements' => $paiements,
            'filters' => $filters,
            'logo_url' => $request->getSchemeAndHttpHost() . '/uploads/logo.jpg',
            'logo_base64' => $logoBase64,
            'title' => 'Relevé des Paiements de Consignation',
            'period' => $this->getPeriodText($filters),
            'total_amount' => array_reduce($paiements, fn($carry, $p) => $carry + $p->getMontant(), 0)
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        $options->set('tempDir', $this->getParameter('kernel.project_dir') . '/var/tmp');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = sprintf('paiements-consignation-%s.pdf', date('Y-m-d'));

        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]
        );
    }

    private function getPeriodText(array $filters): string
    {
        // Vérification plus robuste des filtres
        $dateFrom = $filters['date_from'] ?? null;
        $dateTo = $filters['date_to'] ?? null;
        $dateFilter = $filters['date_filter'] ?? null;

        if ($dateFrom) {
            $toText = $dateTo ? (new \DateTime($dateTo))->format('d/m/Y') : 'à aujourd\'hui';
            return sprintf(
                'Période du %s %s',
                (new \DateTime($dateFrom))->format('d/m/Y'),
                $toText
            );
        }

        if ($dateFilter) {
            $texts = [
                '1h' => 'Dernière heure',
                '24h' => '24 dernières heures',
                '7d' => '7 derniers jours',
                '14d' => '14 derniers jours',
                '30d' => '30 derniers jours',
                '90d' => '90 derniers jours'
            ];
            return $texts[$dateFilter] ?? 'Toutes périodes';
        }

        return 'Toutes périodes';
    }

    #[Route('/verifier', name: 'paiement_consignation_verifier', methods: ['POST'])]
    public function verifier(
        Request $request,
        DossierRepository $dossierRepo,
        MesuresInstructionsRepository $mesuresRepo,
        ReponseMesuresInstructionsRepository $reponseRepo
    ): Response {
        $codeSuivi = $request->request->get('code_suivi');

        $dossier = $dossierRepo->findOneBy(['codeSuivi' => $codeSuivi]);

        if (!$dossier) {
            return $this->render('paiement_consignation/erreur.html.twig', [
                'message' => 'Le code de suivi est invalide.',
            ]);
        }

        if ($dossier->isConsignation()) {
            return $this->render('paiement_consignation/erreur.html.twig', [
                'message' => 'La consignation pour ce dossier a déjà été payée.',
            ]);
        }

        $mesure = $mesuresRepo->findOneBy(['dossier' => $dossier]);

        if (!$mesure) {
            return $this->render('paiement_consignation/erreur.html.twig', [
                'message' => 'Aucune mesure d\'instruction trouvée pour ce dossier.',
            ]);
        }

        $reponse = $reponseRepo->findOneBy(['mesure' => $mesure]);

        if (!$reponse || !($dateNotification = $reponse->getDateNotification()) instanceof \DateTimeImmutable) {
            return $this->render('paiement_consignation/erreur.html.twig', [
                'message' => 'La date de notification est invalide.',
            ]);
        }

        $dateLimite = $dateNotification->modify('+15 days');

        if (new \DateTimeImmutable() > $dateLimite) {
            return $this->render('paiement_consignation/erreur.html.twig', [
                'message' => 'La date limite de paiement est dépassée.',
            ]);
        }

        return $this->redirectToRoute('paiement_consignation_payer', [
            'dossierId' => $dossier->getId(),
        ]);
    }

    #[Route('/payer/{dossierId}', name: 'paiement_consignation_payer', methods: ['GET'])]
    public function payer(string $dossierId, DossierConverter $dossierConverter): Response
    {
        $dossier = $dossierConverter->convert($dossierId);

        FedaPay::setApiKey($_ENV['FEDAPAY_API_KEY']);
        FedaPay::setEnvironment($_ENV['FEDAPAY_ENV']);

        $callbackUrl = $this->generateUrl(
            'paiement_consignation_callback',
            ['dossierId' => $dossier->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        try {
            $transaction = Transaction::create([
                'amount' => 15000,
                'description' => 'Paiement de consignation pour le dossier ' . $dossier->getReferenceDossier(),
                'currency' => ['iso' => 'XOF'],
                'callback_url' => $callbackUrl,
                'customer' => [
                    'email' => $dossier->getRequerant()->getEmail(),
                    'firstname' => $dossier->getRequerant()->getPrenoms(),
                    'lastname' => $dossier->getRequerant()->getNom(),
                ],
            ]);

            return $this->redirect($transaction->generateToken()->url);
        } catch (\Exception $e) {
            $this->logger->error('Erreur création transaction', [
                'error' => $e->getMessage(),
                'dossier_id' => $dossierId
            ]);
            return $this->redirectToRoute('paiement_consignation_index');
        }
    }

    #[Route('/callback/{dossierId}', name: 'paiement_consignation_callback', methods: ['GET'])]
    public function callback(
        string $dossierId,
        Request $request,
        DossierConverter $dossierConverter,
        FileUploader $fileUploader
    ): Response {
        $transactionId = $request->query->get('id');
        $status = $request->query->get('status', 'pending');

        if (!$transactionId) {
            $this->logger->error('Transaction ID manquant', ['dossier_id' => $dossierId]);
            return $this->renderError('ID de transaction manquant.');
        }

        try {
            FedaPay::setApiKey($_ENV['FEDAPAY_API_KEY']);
            FedaPay::setEnvironment($_ENV['FEDAPAY_ENV']);

            $isSandbox = (FedaPay::getEnvironment() === 'sandbox');
            $dossier = $dossierConverter->convert($dossierId);

            if (!$dossier) {
                throw new \RuntimeException("Dossier $dossierId introuvable");
            }

            if ($isSandbox && $status === 'pending') {
                $transaction = new \FedaPay\Transaction();
                $transaction->id = $transactionId;
                $transaction->amount = 15000;
                $transaction->status = 'approved';
                $transaction->mode = 'MTN';
                $transaction->created_at = new \DateTime();
            } else {
                $transaction = Transaction::retrieve($transactionId);

                if (!$transaction instanceof \FedaPay\Transaction) {
                    throw new \RuntimeException("Type de transaction invalide");
                }

                if ($transaction->status !== 'approved') {
                    $this->logger->error('Transaction non approuvée', [
                        'status' => $transaction->status
                    ]);
                    return $this->renderError("Paiement non approuvé (Statut: {$transaction->status})");
                }
            }

            return $this->processPayment($dossier, $transaction, $fileUploader);
        } catch (\Exception $e) {
            $this->logger->error('Erreur callback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->renderError('Erreur technique. Référence: ' . $transactionId);
        }
    }

    #[Route(path: '/consignation/{id}', name: 'greffier_dossier_consignation')]
    public function paiementConsigne(Request $request, Dossier $dossier, FileUploader $fileUploader, DossierRepository $dossierRepository): Response
    {
        $form = $this->createForm(ConsignationDossierType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('document')->getData()) {
                $image = $form->get('document')->getData();
                $fmane = $dossier->getReferenceDossier();
                $fichier = $fileUploader->upload($image, $fmane, 'piecesJointes');
                $dossier->setPreuveConsignationRequerant($fichier);
                $dossier->setDatePreuveConsignationRequerant(new \DateTimeImmutable());
                $dossier->setRecuConsignation(true);
            }

            $dossierRepository->add($dossier, true);
            $user = $this->getUser();
            if ($user && in_array('ROLE_GREFFIER', $user->getRoles())) {
                // Si greffier, on retourne sur la page spéciale greffier
                return $this->redirectToRoute('greffier_dossier_open_list'); // <-- Remplace par la bonne route
            } else {
                return $this->redirectToRoute('app_index_front');
            }
        }

        $templateParent = $this->getUser() ? 'base.html.twig' : 'front/status_base.html.twig';

        return $this->render('greffe/paiementConsignation.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
            'template_parent' => $templateParent,
        ]);
    }

    // ADMIN SECTION - CRUD
    #[Route('/admin/list', name: 'paiement_consignation_admin_list', methods: ['GET'])]
    public function list(
        Request $request,
        PaiementConsignationRepository $paiementRepo
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_GREFFIER_EN_CHEF');

        $dateFilter = $request->query->get('date_filter', 'all');

        try {
            // Récupération des paiements filtrés
            $qb = $paiementRepo->createQueryBuilder('p')
                ->select('p', 'd')
                ->join('p.dossier', 'd')
                ->orderBy('p.datePaiement', 'DESC');

            // Application du filtre de date
            if ($dateFilter !== 'all') {
                $date = new \DateTime();
                switch ($dateFilter) {
                    case '1h':
                        $date->modify('-1 hour');
                        break;
                    case '24h':
                        $date->modify('-1 day');
                        break;
                    case '7d':
                        $date->modify('-7 days');
                        break;
                    case '14d':
                        $date->modify('-14 days');
                        break;
                    case '30d':
                        $date->modify('-30 days');
                        break;
                    case '90d':
                        $date->modify('-90 days');
                        break;
                }
                $qb->andWhere('p.datePaiement >= :date')
                    ->setParameter('date', $date);
            }

            $paiements = $qb->getQuery()->getResult();

            // Calcul des statistiques
            $stats = [
                'total_paiements' => count($paiements),
                'paiements_24h' => $paiementRepo->countLast24h(),
                'paiements_7j' => $paiementRepo->countLast7Days(),
                'paiements_30j' => $paiementRepo->countLast30Days(),
                'total_montant' => array_reduce($paiements, fn($carry, $p) => $carry + $p->getMontant(), 0),
                'montant_24h' => $paiementRepo->sumLast24h(),
                'montant_7j' => $paiementRepo->sumLast7Days(),
                'montant_30j' => $paiementRepo->sumLast30Days(),
            ];

            return $this->render('paiement_consignation/admin/list.html.twig', [
                'paiements' => $paiements,
                'current_filter' => $dateFilter,
                'is_greffier' => true,
                ...$stats
            ]);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur technique est survenue');
            $this->logger->error('Erreur liste paiements', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->render('paiement_consignation/admin/list.html.twig', [
                'paiements' => [],
                'current_filter' => $dateFilter,
                'is_greffier' => true,
                'total_paiements' => 0,
                'paiements_24h' => 0,
                'paiements_7j' => 0,
                'paiements_30j' => 0,
                'total_montant' => 0,
                'montant_24h' => 0,
                'montant_7j' => 0,
                'montant_30j' => 0
            ]);
        }
    }

    #[Route('/admin/{id}/show', name: 'paiement_consignation_admin_show', methods: ['GET'])]
    public function adminShow(
        PaiementConsignation $paiement,
        EntityManagerInterface $em
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_GREFFIER_EN_CHEF');

        // Version basique sans vérification complexe
        return $this->render('paiement_consignation/admin/show.html.twig', [
            'paiement' => $paiement,
        ]);
    }


    // PRIVATE METHODS
    private function processPayment(Dossier $dossier, $transaction, FileUploader $fileUploader): Response
    {
        $this->em->beginTransaction();
        $tempPdfPath = null;

        try {
            $pdfContent = $this->generatePaymentProof($transaction, $dossier);
            $tempPdfPath = $this->saveTempFile($pdfContent, $transaction->id);
            $pdfPath = $this->uploadProofFile($tempPdfPath, $dossier->getId(), $fileUploader);

            $this->registerPayment($dossier, $transaction, $pdfPath);
            $this->sendConfirmationEmail($dossier, $tempPdfPath);

            $this->em->commit();
            return $this->renderSuccess($dossier);
        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        } finally {
            if ($tempPdfPath && file_exists($tempPdfPath)) {
                @unlink($tempPdfPath);
            }
        }
    }

    private function generatePaymentProof($transaction, $dossier): string
    {
        try {
            $transactionData = [
                'id' => $transaction->id,
                'amount' => $transaction->amount,
                'mode' => $transaction->mode ?? 'Inconnu',
                'date' => $transaction->created_at ?? new \DateTime(),
                'status' => $transaction->status ?? 'approved'
            ];

            $html = $this->renderView('paiement_consignation/preuve_pdf.html.twig', [
                'transaction' => $transactionData,
                'dossier' => $dossier,
                'date_emission' => new \DateTime(),
                'sandbox' => ($transaction->mode === 'Sandbox')
            ]);

            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('chroot', $this->projectDir);
            $options->set('tempDir', $this->projectDir . '/var/tmp');
            $options->set('defaultFont', 'DejaVu Sans');

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return $dompdf->output();
        } catch (\Exception $e) {
            $this->logger->error("Erreur génération PDF", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \RuntimeException("Échec de génération du PDF: " . $e->getMessage());
        }
    }

    private function saveTempFile(string $content, string $transactionId): string
    {
        $tempPath = sys_get_temp_dir() . '/preuve_' . $transactionId . '_' . time() . '.pdf';
        if (file_put_contents($tempPath, $content) === false) {
            throw new \RuntimeException("Échec création fichier temporaire");
        }
        return $tempPath;
    }

    private function uploadProofFile(string $filePath, string $dossierId, FileUploader $uploader): string
    {
        $pdfFile = new UploadedFile(
            $filePath,
            'preuve_consignation_' . $dossierId . '.pdf',
            'application/pdf',
            null,
            true
        );

        $path = $uploader->upload($pdfFile, 'consignations');
        if (!$path) {
            throw new \RuntimeException("Échec upload fichier");
        }
        return $path;
    }

    private function registerPayment(Dossier $dossier, $transaction, string $pdfPath, MesuresInstructionsRepository $mesure): void
    {
        $paiement = new PaiementConsignation();
        $paiement->setDossier($dossier);
        $paiement->setDatePaiement(new \DateTimeImmutable());
        $paiement->setMontant($transaction->amount);
        $paiement->setPreuveConsignation($pdfPath);
        $paiement->setConsignation(true);
        $paiement->setIdTransaction($transaction->id);
        $paiement->setModePaiement($transaction->mode ?? 'Inconnu');

        $dossier->setConsignation(true);
        $dossier->setDateConsignation(new \DateTimeImmutable());
        $dossier->setPreuveConsignation($pdfPath);
        $mesure_instruction = $mesure->findOneBy(['dossier' => $dossier]);
        $mesure_instruction->setEtat('EXECUTE');

        $this->em->persist($paiement);
        $this->em->flush();
    }

    private function sendConfirmationEmail(Dossier $dossier, string $pdfPath): void
    {
        try {
            $email = (new Email())
                ->from('no-reply@example.com')
                ->to($dossier->getRequerant()->getEmail())
                ->subject("Confirmation paiement dossier #{$dossier->getId()}")
                ->html($this->renderView('emails/confirmation_consignation.html.twig', [
                    'dossier' => $dossier
                ]))
                ->attach(fopen($pdfPath, 'r'), "preuve_paiement.pdf");

            $this->mailer->send($email);
        } catch (\Exception $e) {
            $this->logger->error('Erreur envoi email', [
                'error' => $e->getMessage(),
                'dossier_id' => $dossier->getId()
            ]);
        }
    }

    private function canAccessDossier($user, $dossier, DossierRepository $dossierRepo): bool
    {
        return $dossierRepo->isUserAffectedToDossier($user, $dossier);
    }

    private function renderError(string $message): Response
    {
        return $this->render('paiement_consignation/erreur.html.twig', [
            'message' => $message
        ]);
    }

    private function renderSuccess(Dossier $dossier): Response
    {
        return $this->render('paiement_consignation/success.html.twig', [
            'dossier' => $dossier
        ]);
    }
}
