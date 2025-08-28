<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\MailService;
use Symfony\Component\Mime\Email;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReponseMesuresInstructionsRepository;
use App\Repository\DossierRepository;
use App\Repository\MesuresInstructionsRepository;
use DateTimeImmutable;


#[AsCommand(
    name: 'alerte-mesure-instruction',
    description: 'Automatisation des alertes pour les mesures d\'instruction',
)]
class AlerteMesureInstructionCommand extends Command
{

    private $entityManager;
    private $mailer;
    private $reponseRepository;
    private $dossierRepository;
    private $mesuresInstructionsRepository;
    private $logger;

    private const SEUILS_ALERTE = [
        'critique' => 0,    // Jour de l'expiration
        'urgent' => 2,      // 2 jours avant
        'attention' => 5,   // 5 jours avant
        'information' => 10, // 10 jours avant

    ];

    public function __construct(
        EntityManagerInterface $entityManager,
        MailService $mailer,
        ReponseMesuresInstructionsRepository $reponseRepository,
        DossierRepository $dossierRepository,
        LoggerInterface $logger,
        MesuresInstructionsRepository $mesuresInstructionsRepository
    ) {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->reponseRepository = $reponseRepository;
        $this->dossierRepository = $dossierRepository;
        $this->mesuresInstructionsRepository = $mesuresInstructionsRepository;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title("Analyse des mesures d'instruction");

        $dossiers = $this->dossierRepository->findAll();

        foreach ($dossiers as $dossier) {
            $mesure = $this->mesuresInstructionsRepository->findOneBy(
                ['dossier' => $dossier],
                ['createdAt' => 'DESC']
            );

            if (!$mesure) {
                $msg = "Aucune mesure trouvée pour le dossier {$dossier->getReferenceDossier()}";
                $io->warning($msg);
                $this->logger->warning($msg);
                continue;
            }

            // Mesure en cours
            if ($mesure->getEtat() === 'EN COURS') {
                $msg = "Mesure en cours détectée pour le dossier {$dossier->getReferenceDossier()}";
                $io->success($msg);
                $this->logger->info($msg);

                $output->writeln(sprintf(
                    'Le dossier : %s a pour dernière mesure d\'instruction : %s et finit le : %s',
                    $dossier->getReferenceDossier(),
                    $mesure->getInstruction()->getLibelle(),
                    $mesure->getTermineAt()->format('Y-m-d')
                ));
            }

            // Partie contactée
            if ($mesure->getEtat() == 'CONTACTE') {
                $msg = sprintf(
                    "Le partie a été contacté le %s pour le dossier %s",
                    $mesure->getReponses()->getDateNotification()->format('Y-m-d'),
                    $dossier->getReferenceDossier()
                );

                $io->success($msg);
                $this->logger->info($msg);

                $restant_day = $this->nombrejourrestant($mesure->getTermineAt());
                if ($restant_day < 0) {
                    $restant_day = ($restant_day * (-1));
                    $niveau = 'echec';
                    $mesure->setEtat('ECHOUE');
                    $this->entityManager->persist($mesure);
                    $this->entityManager->flush();
                    $alerteMsg = sprintf(
                        'La mesure d\'instruction pour le dossier %s est expirée depuis %d jours.',
                        $dossier->getReferenceDossier(),
                        $restant_day
                    );

                    // Console + log
                    $output->writeln($alerteMsg);
                    $this->logger->info($alerteMsg);

                    // Envoi des mails
                    foreach ($dossier->getUserDossiers() as $userDossier) {
                        $this->sendMailToRapporteur($userDossier, $mesure, $dossier, $niveau);
                    }

                    continue; // Passer à la prochaine mesure
                } else {
                    foreach (self::SEUILS_ALERTE as $niveau => $seuil) {
                        if ($restant_day == $seuil) {
                            $alerteMsg = sprintf(
                                "L'alerte est de niveau : %s car la mesure finit dans : %s jours",
                                $niveau,
                                $restant_day
                            );

                            // Console + log
                            $output->writeln($alerteMsg);
                            $this->logger->info($alerteMsg);

                            // Envoi des mails
                            foreach ($dossier->getUserDossiers() as $userDossier) {
                                $this->sendMailToRapporteur($userDossier, $mesure, $dossier, $niveau);
                            }

                            break; // On sort de la boucle des seuils
                        }
                    }
                }
            }
        }

        $io->success("Analyse terminée.");

        return Command::SUCCESS;
    }

    private function sendLogger(\DateTimeInterface $termineAt, OutputInterface $output): void
    {
        $restant_day = $this->nombrejourrestant($termineAt);

        foreach (self::SEUILS_ALERTE as $niveau => $seuil) {
            if ($restant_day == $seuil) {
                $output->writeln(sprintf(
                    'L\'alerte est de niveau : %s car la mesure finit dans : %s jours',
                    $niveau,
                    $restant_day
                ));
                break;
            }
        }
    }

    private function nombrejourrestant(\DateTimeInterface $termineAt): int
    {
        $now = new DateTimeImmutable('today');
        $interval = $now->diff($termineAt);
        return $interval->invert ? -$interval->days : $interval->days;
    }

    private function sendMailToRapporteur($userDossier, $mesuresInstructions, $dossier, $niveau)
    {

        $mail = $userDossier->getUser()->getUserIdentifier();
        $sujet = "Information mesure d'instruction du dossier";

        $context = [
            'destinataire' => $userDossier->getUser()->getUserInformations(),
            'profile' => $userDossier->getProfil(),
            'mesureInstruction' => $mesuresInstructions,
            'dossier_objet' => $dossier->getObjet()->getName(),
            'ResponsemesureInstruction' => new DateTimeImmutable(),
            'nomRequerant' => $dossier->getRequerant()->getNomComplet(),
            'infoConseille' => $dossier->getRequerant()->getConseiller(),
            'numeroRecours' => $dossier->getReferenceDossier() ?? $dossier->getCodeSuivi(),
            'mesureInstructionLibelle' => $mesuresInstructions->getInstruction()->getLibelle(),
            'delais' => $mesuresInstructions->getInstruction()->getDelais(),
            'date_debut_mesure' => $mesuresInstructions->getCreatedAt(),
            'date_fin_mesure' => $mesuresInstructions->getTermineAt(),
            'niveau_alert' => $niveau,
            'joursRestants' => date_diff(
                new DateTimeImmutable(),
                $mesuresInstructions->getTermineAt()
            )->days,
            // 'lien' => $this->generateUrl('front_recours_status', [], UrlGeneratorInterface::ABSOLUTE_URL)
        ];

        $this->mailer->sendEmail($mail, $sujet, 'alerte_notification_mesure/rapporteurs/alerte-mail-user-instruction.html.twig', $context);
        $this->logger->info("La commande app:send-mail-and-log a été exécutée. Mail envoyer à :{$mail} pour le dossier {$dossier->getReferenceDossier()}");
    }
}
