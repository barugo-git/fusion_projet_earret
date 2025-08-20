<?php

namespace App\Controller;

use App\Entity\Audience;
use App\Entity\User;
use App\Entity\Rapport;
use App\Entity\Dossier;
use App\Entity\AvisPaquet;
use App\Entity\PaiementConsignation;
use App\Entity\MesuresInstructions;
use App\Entity\DossierAudience;
use App\Entity\DeliberationDossiers;
use App\Entity\Arrets;
use App\Repository\ArretsRepository;
use App\Repository\AudienceRepository;
use App\Repository\DossierRepository;
use App\Repository\UserDossierRepository;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class IndexController extends AbstractController
{
    #[Route(path: '/dashboard', name: 'app_index')]
    public function index(EntityManagerInterface $em, #[CurrentUser] User $user, LoggerInterface $dbLogger, DossierRepository $dossierRepository): Response
    {
        $dbLogger->info('Notre premier log');

        // 1. Nombre de recours enregistrés
        $nbRecours = $dossierRepository->count([]);

        // 2. Nombre de dossiers ouverts (statut = 'OUVERT')
        $nbDossiersOuverts = $dossierRepository->count(['etatDossier' => 'OUVERT']);

        // 3. Nombre de dossiers en attente d'audience (dossiers qui ne sont pas fermés ou délibérés, par exemple)
        $nbredossierenattenteaudience = $em->getRepository(Dossier::class)
            ->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.etatDossier IN (:etats)')
            ->setParameter('etats', ['NOUVEAU', 'OUVERT', 'Dossier en instruction', 'Dossier au Parquet'])
            ->getQuery()
            ->getSingleScalarResult();
        
        // 4. Nombre de dossiers en instruction (statut = 'Dossier en instruction')
        $nbDossiersInstruction = $dossierRepository->count(['etatDossier' => 'Dossier en instruction']);
        
        // 5. Nombre de dossiers au Parquet
        $nbDossiersParquet = $em->getRepository(Dossier::class)
            ->count(['etatDossier' => 'Dossier au Parquet']);

        // 6. Nombre d'audiences programmées
        $nbAudiencesProgrammees = $em->getRepository(Audience::class)->count([]);

        // 7. Nombre d'arrêts
        $nbArrets = $em->getRepository(Arrets::class)->count([]);

        // 8. Montant total consignation
        $montantConsignation = $em->getRepository(PaiementConsignation::class)
            ->createQueryBuilder('p')
            ->select('SUM(p.montant) as total')
            ->getQuery()
            ->getSingleScalarResult() ?? 0;

        // 9. Nombre de dossiers vidés (supposons que c'est le nombre total d'arrêts)
        $nbDossiersVides = $nbArrets;

        // 10. Dossiers mis en délibéré
        $nbDossiersDelibere = $em->getRepository(DeliberationDossiers::class)->count([]);

        // 11. Gestion des six types de rapports
        $rapportStats = $em->getRepository(Rapport::class)
            ->createQueryBuilder('r')
            ->select('r.typeRapport as type, COUNT(r.id) as count')
            ->groupBy('r.typeRapport')
            ->getQuery()
            ->getResult();

        $nbDecheance = 0;
        $nbForclusion = 0;
        $nbFond = 0;

        foreach ($rapportStats as $stat) {
            switch ($stat['type']) {
                case 'Déchéance':
                    $nbDecheance = $stat['count'];
                    break;
                case 'Forclusion':
                    $nbForclusion = $stat['count'];
                    break;
                case 'Fond':
                    $nbFond = $stat['count'];
                    break;
            }
        }

        return $this->render('index.html.twig', [
            'nbRecours' => $nbRecours,
            'nbDossiersOuverts' => $nbDossiersOuverts,
            'nbDossiersInstruction' => $nbDossiersInstruction,
            'nbDossiersParquet' => $nbDossiersParquet,
            'nbAudiencesProgrammees' => $nbAudiencesProgrammees,
            'nbArrets' => $nbArrets,
            'montantConsignation' => $montantConsignation,
            'nbDossiersVides' => $nbDossiersVides,
            'nbDossiersDelibere' => $nbDossiersDelibere,
            'nbDecheance' => $nbDecheance,
            'nbForclusion' => $nbForclusion,
            'nbFond' => $nbFond,
        ]);
    }
}