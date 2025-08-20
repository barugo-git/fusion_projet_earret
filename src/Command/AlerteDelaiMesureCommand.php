<?php

namespace App\Command;

use App\Repository\ReponseMesuresInstructionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'app:alerte-delai-mesure',
    description: 'Vérifie et affiche les alertes pour les mesures d\'instruction dont le délai arrive à expiration',
)]
class AlerteDelaiMesureCommand extends Command
{
    private const SEUILS_ALERTE = [
        'critique' => 0,    // Jour de l'expiration
        'urgent' => 2,      // 2 jours avant
        'attention' => 5,   // 5 jours avant
        'information' => 10 // 10 jours avant
    ];

    private $entityManager;
    private $mailer;
    private $reponseRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        MailerInterface $mailer,
        ReponseMesuresInstructionsRepository $reponseRepository
    ) {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->reponseRepository = $reponseRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Vérification des délais des mesures d\'instruction');

        $reponses = $this->reponseRepository->findBy([
            'termine' => false
        ]);

        if (empty($reponses)) {
            $io->info('Aucune réponse en attente trouvée.');
            return Command::SUCCESS;
        }

        $io->section('Analyse des délais en cours...');

        $alertes = [];
        $erreurs = [];

        foreach ($reponses as $reponse) {
            try {
                $this->analyserReponse($reponse, $alertes, $io);
            } catch (\Exception $e) {
                $erreurs[] = sprintf("Erreur pour la réponse %s : %s", $reponse->getId(), $e->getMessage());
            }
        }

        // Affichage des résultats
        $this->afficherResultats($io, $alertes, $erreurs);

        return Command::SUCCESS;
    }

    private function analyserReponse($reponse, array &$alertes, SymfonyStyle $io): void
    {
        $dateNotification = $reponse->getDateNotification();
        if (!$dateNotification) {
            $io->warning(sprintf('Réponse %s : Pas de date de notification', $reponse->getId()));
            return;
        }

        $mesure = $reponse->getMesure();
        if (!$mesure) {
            $io->warning(sprintf('Réponse %s : Pas de mesure associée', $reponse->getId()));
            return;
        }

        $delai = $mesure->getInstruction()->getDelais();
        $dateFinDelai = $this->calculerDateFinDelai($dateNotification, $delai);
        $joursRestants = $this->calculerJoursRestants($dateFinDelai);

        $alerte = [
            'id_reponse' => $reponse->getId(),
            'reference_dossier' => $mesure->getDossier()->getReferenceDossier(),
            'type_instruction' => $mesure->getInstruction()->getLibelle(),
            'date_notification' => $dateNotification->format('d/m/Y'),
            'delai_initial' => $delai,
            'jours_restants' => $joursRestants,
            'destinataires' => $this->getDestinataires($mesure)
        ];

        if ($joursRestants < 0) {
            $alerte['type'] = 'DÉPASSEMENT';
            $alerte['message'] = sprintf('⚠️ Délai dépassé de %d jours', abs($joursRestants));
            $alertes['depassements'][] = $alerte;
        } else {
            foreach (self::SEUILS_ALERTE as $niveau => $seuil) {
                if ($joursRestants === $seuil) {
                    $alerte['type'] = $niveau;
                    $alerte['message'] = sprintf('🔔 Il reste %d jours', $joursRestants);
                    $alertes[$niveau][] = $alerte;
                    break;
                }
            }
        }
    }

    private function getDestinataires($mesure): array
    {
        $destinataires = [];

        if ($mesure->getGreffier()) {
            $destinataires['greffier'] = $mesure->getGreffier()->getEmail();
        }

        if ($mesure->getConseillerRapporteur()) {
            $destinataires['conseiller'] = $mesure->getConseillerRapporteur()->getEmail();
        }

        return $destinataires;
    }

    private function afficherResultats(SymfonyStyle $io, array $alertes, array $erreurs): void
    {
        if (empty($alertes)) {
            $io->info('Aucune alerte à envoyer aujourd\'hui.');
            return;
        }

        // Affichage des dépassements
        if (!empty($alertes['depassements'])) {
            $io->section('🚨 Délais dépassés');
            foreach ($alertes['depassements'] as $alerte) {
                $this->afficherAlerte($io, $alerte, 'error');
            }
        }

        // Affichage des alertes critiques
        if (!empty($alertes['critique'])) {
            $io->section('⚠️ Alertes critiques (échéance aujourd\'hui)');
            foreach ($alertes['critique'] as $alerte) {
                $this->afficherAlerte($io, $alerte, 'error');
            }
        }

        // Affichage des alertes urgentes
        if (!empty($alertes['urgent'])) {
            $io->section('⚠️ Alertes urgentes (2 jours)');
            foreach ($alertes['urgent'] as $alerte) {
                $this->afficherAlerte($io, $alerte, 'warning');
            }
        }

        // Affichage des alertes d'attention
        if (!empty($alertes['attention'])) {
            $io->section('⚠️ Alertes d\'attention (5 jours)');
            foreach ($alertes['attention'] as $alerte) {
                $this->afficherAlerte($io, $alerte, 'comment');
            }
        }

        // Affichage des alertes d'information
        if (!empty($alertes['information'])) {
            $io->section('ℹ️ Alertes d\'information (10 jours)');
            foreach ($alertes['information'] as $alerte) {
                $this->afficherAlerte($io, $alerte, 'comment');
            }
        }

        // Affichage des erreurs s'il y en a
        if (!empty($erreurs)) {
            $io->section('❌ Erreurs rencontrées');
            foreach ($erreurs as $erreur) {
                $io->error($erreur);
            }
        }
    }

    private function afficherAlerte(SymfonyStyle $io, array $alerte, string $style): void
    {
        $message = [
            sprintf('Dossier : %s', $alerte['reference_dossier']),
            sprintf('Instruction : %s', $alerte['type_instruction']),
            sprintf('Date notification : %s', $alerte['date_notification']),
            sprintf('Délai initial : %d jours', $alerte['delai_initial']),
            $alerte['message'],
            '',
            'Destinataires :'
        ];

        foreach ($alerte['destinataires'] as $role => $email) {
            $message[] = sprintf('- %s : %s', ucfirst($role), $email);
        }

        $io->$style($message);
    }

    private function calculerDateFinDelai($dateNotification, int $delai): \DateTime
    {
        return (new \DateTime())
            ->setTimestamp($dateNotification->getTimestamp())
            ->modify("+{$delai} days");
    }

    private function calculerJoursRestants($dateFinDelai): int
    {
        $now = new \DateTime('midnight');
        $finDelai = (new \DateTime())
            ->setTimestamp($dateFinDelai->getTimestamp())
            ->setTime(23, 59, 59);

        $interval = $now->diff($finDelai);
        return $interval->invert ? -$interval->days : $interval->days;
    }
}
