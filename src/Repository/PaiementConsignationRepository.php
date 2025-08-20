<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\PaiementConsignation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

class PaiementConsignationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaiementConsignation::class);
    }

    public function findForUserWithFilters(User $user, string $dateFilter = 'all')
    {
        $conn = $this->getEntityManager()->getConnection();

        // Requête SQL pour récupérer les paiements
        $sql = "SELECT pc.* FROM paiement_consignation pc
                JOIN dossier d ON pc.dossier_id = d.id
                JOIN affecter_section af ON d.id = af.dossier_id
                WHERE af.greffier_id = :userId";

        // Ajout du filtre de date si nécessaire
        if ($dateFilter !== 'all') {
            $interval = $this->getDateInterval($dateFilter);
            $sql .= " AND pc.date_paiement >= DATE_SUB(NOW(), INTERVAL $interval)";
        }

        // Tri par date décroissante
        $sql .= " ORDER BY pc.date_paiement DESC";

        // Exécution de la requête
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery(['userId' => $user->getId()]);

        // Transformation des résultats en objets PaiementConsignation
        return $this->transformToEntities($result->fetchAllAssociative());
    }

    private function getDateInterval(string $filter): string
    {
        switch ($filter) {
            case '1h': return '1 HOUR';
            case '24h': return '24 HOUR';
            case '7d': return '7 DAY';
            case '14d': return '14 DAY';
            case '30d': return '30 DAY';
            case '90d': return '90 DAY';
            default: return '100 YEAR'; // Pour 'all'
        }
    }

    private function transformToEntities(array $results): array
    {
        $entities = [];
        $em = $this->getEntityManager();

        foreach ($results as $row) {
            $entity = $this->createEntity($row);
            if ($entity) {
                $entities[] = $entity;
            }
        }

        return $entities;
    }

    private function createEntity(array $data): ?PaiementConsignation
    {
        try {
            $entity = new PaiementConsignation();
            
            // Utilisez la réflexion ou les setters pour hydrater l'objet
            $reflection = new \ReflectionClass($entity);
            
            foreach ($data as $key => $value) {
                // Convertit les noms de colonnes snake_case en camelCase
                $propertyName = lcfirst(str_replace('_', '', ucwords($key, '_')));
                
                if ($reflection->hasProperty($propertyName)) {
                    $property = $reflection->getProperty($propertyName);
                    $property->setAccessible(true);
                    
                    // Convertit les dates si nécessaire
                    if ($property->getType()->getName() === 'DateTime' && $value !== null) {
                        $value = new \DateTime($value);
                    }
                    
                    $property->setValue($entity, $value);
                }
            }
            
            return $entity;
        } catch (\Exception $e) {
            // Log l'erreur si nécessaire
            return null;
        }
    }

    // Méthode de debug améliorée
    public function debugRelations(User $user): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT 
                    pc.id as paiement_id,
                    d.id as dossier_id,
                    d.code_suivi as dossier_code,
                    af.greffier_id,
                    af.conseiller_rapporteur_id,
                    pc.date_paiement,
                    pc.montant
                FROM paiement_consignation pc
                JOIN dossier d ON pc.dossier_id = d.id
                LEFT JOIN affecter_section af ON d.id = af.dossier_id
                WHERE af.greffier_id = :userId";

        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery(['userId' => $user->getId()]);

        return $result->fetchAllAssociative();
    }

    // PaiementConsignationRepository.php
    public function countLast24h(): int
    {
        $date = new \DateTime('-24 hours');
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('p.datePaiement >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countLast7Days(): int
    {
        $date = new \DateTime('-7 days');
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('p.datePaiement >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countLast30Days(): int
    {
        $date = new \DateTime('-30 days');
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('p.datePaiement >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function sumAll(): float
    {
        return $this->createQueryBuilder('p')
            ->select('SUM(p.montant)')
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }

    public function sumLast24h(): float
    {
        $date = new \DateTime('-24 hours');
        return $this->createQueryBuilder('p')
            ->select('SUM(p.montant)')
            ->where('p.datePaiement >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }

    public function sumLast7Days(): float
    {
        $date = new \DateTime('-7 days');
        return $this->createQueryBuilder('p')
            ->select('SUM(p.montant)')
            ->where('p.datePaiement >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }

    public function sumLast30Days(): float
    {
        $date = new \DateTime('-30 days');
        return $this->createQueryBuilder('p')
            ->select('SUM(p.montant)')
            ->where('p.datePaiement >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }

    // src/Repository/PaiementConsignationRepository.php
    public function findWithFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.dossier', 'd');
        
        if (!empty($filters['search'])) {
            $qb->andWhere('p.idTransaction LIKE :search OR d.codeSuivi LIKE :search')
            ->setParameter('search', '%'.$filters['search'].'%');
        }
        
        if (!empty($filters['date_from'])) {
            $qb->andWhere('p.datePaiement >= :date_from')
            ->setParameter('date_from', new \DateTime($filters['date_from']));
        }
        
        if (!empty($filters['date_to'])) {
            $qb->andWhere('p.datePaiement <= :date_to')
            ->setParameter('date_to', new \DateTime($filters['date_to']));
        }
        
        if (!empty($filters['mode'])) {
            $qb->andWhere('p.modePaiement = :mode')
            ->setParameter('mode', $filters['mode']);
        }
        
        // Ajoutez le filtre de période si nécessaire (comme dans votre liste)
        if (!empty($filters['date_filter']) && $filters['date_filter'] !== 'all') {
            $date = new \DateTime();
            switch ($filters['date_filter']) {
                case '1h': $date->modify('-1 hour'); break;
                case '24h': $date->modify('-1 day'); break;
                case '7d': $date->modify('-7 days'); break;
                case '14d': $date->modify('-14 days'); break;
                case '30d': $date->modify('-30 days'); break;
                case '90d': $date->modify('-90 days'); break;
            }
            $qb->andWhere('p.datePaiement >= :date_filter')
            ->setParameter('date_filter', $date);
        }
        
        return $qb->getQuery()->getResult();
    }
}