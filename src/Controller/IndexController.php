<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Rapport;
use App\Repository\ArretsRepository;
use App\Repository\AudienceRepository;
use App\Repository\DossierRepository;
use App\Repository\UserDossierRepository;
use Psr\Log\LoggerInterface;
use App\Entity\Dossier;
use App\Entity\MesuresInstructions;
use App\Entity\AvisPaquet;
use App\Entity\DossierAudience;
use App\Entity\DeliberationDossiers;
use App\Entity\Arrets;
use App\Entity\PaiementConsignation;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class IndexController extends AbstractController
{
    #[Route(path: '/dashboard', name: 'app_index')]
    public function index(EntityManagerInterface $em): Response
    {

        $user = $this->getUser();
        
        // 1. Nombre de recours enregistrés (tous les dossiers distincts)
        $nbRecours = $em->getRepository(Dossier::class)
            ->createQueryBuilder('d')
            ->select('COUNT(DISTINCT d.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // 2. Nombre de dossiers ouverts (statut = 'OUVERT')
        $nbDossiersOuverts = $em->getRepository(Dossier::class)
            ->count(['etatDossier' => 'OUVERT']);

        // 3. Nombre de dossiers en instruction (dossiers distincts dans mesures_instructions)
        $nbDossiersInstruction =  $em->getRepository(Dossier::class)
        ->count(['etatDossier' => 'Dossier en instruction']);

        // 4. Nombre de dossiers au Parquet (dossiers distincts dans avis_paquet)
        $nbDossiersParquet = $em->getRepository(AvisPaquet::class)
            ->createQueryBuilder('ap')
            ->select('COUNT(DISTINCT ap.dossier)')
            ->getQuery()
            ->getSingleScalarResult();

        // 5. Nombre d'audiences programmées (dossiers distincts dans arrets)
        $nbAudiencesProgrammees = $em->getRepository(Arrets::class)
            ->createQueryBuilder('a')
            ->select('COUNT(DISTINCT a.dossier)')
            ->getQuery()
            ->getSingleScalarResult();

        // 6. Nombre d'arrêts (tous les arrêts)
        $nbArrets = $em->getRepository(Arrets::class)->count([]);

        // 7. Montant total consignation
        $montantConsignation = $em->getRepository(PaiementConsignation::class)
            ->createQueryBuilder('p')
            ->select('SUM(p.montant) as total')
            ->getQuery()
            ->getSingleScalarResult() ?? 0;

        // 8. Nombre de dossiers vidés (supposons que c'est le nombre total d'arrêts)
        $nbDossiersVides = $nbArrets; 

        // 9. Montant total consignation
        $montantConsignation = $em->getRepository(PaiementConsignation::class)
            ->createQueryBuilder('p')
            ->select('SUM(p.montant) as total')
            ->getQuery()
            ->getSingleScalarResult() ?? 0;

        // 10. Dossiers mis en délibéré
        $nbDossiersDelibere = $em->getRepository(DeliberationDossiers::class)->count([]);

        // 11. Gestion des six types de rapports
        // Récupération des statistiques par type de rapport
        $rapportStats = $em->getRepository(Rapport::class)
        ->createQueryBuilder('r')
        ->select('r.typeRapport as type, COUNT(r.id) as count')
        ->groupBy('r.typeRapport')
        ->getQuery()
        ->getResult();

        // Initialisation des compteurs pour chaque type
        $nbDecheance = 0;
        $nbForclusion = 0;
        $nbFond = 0;

        // Remplissage des compteurs
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