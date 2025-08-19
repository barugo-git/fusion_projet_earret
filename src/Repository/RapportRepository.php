<?php

namespace App\Repository;
namespace App\Repository;

use App\Entity\Rapport;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class RapportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rapport::class);
    }

    public function countForUserOrStructure(User $user, \DateTimeInterface $startDate = null): int
    {
        $qb = $this->createQueryBuilder('r')
            ->select('COUNT(r.id)');
        
        if (in_array('ROLE_CONSEILLER', $user->getRoles())) {
            $qb->join('r.created_by', 'u')
                ->andWhere('u.email = :email')
                ->setParameter('email', $user->getUserIdentifier());
        } elseif (in_array('ROLE_PCJ', $user->getRoles())) {
            $qb->join('r.dossier', 'd')
                ->join('d.structure', 's')
                ->andWhere('s.name = :structure')
                ->setParameter('structure', 'Chambre Judiciaire');
        } elseif (in_array('ROLE_PCA', $user->getRoles())) {
            $qb->join('r.dossier', 'd')
                ->join('d.structure', 's')
                ->andWhere('s.name = :structure')
                ->setParameter('structure', 'Chambre Administrative');
        }

        if ($startDate) {
            $qb->andWhere('r.created_at >= :startDate')
                ->setParameter('startDate', $startDate);
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function countByFilters(array $filters, ?\DateTimeInterface $startDate = null): int
    {
        $qb = $this->createQueryBuilder('r')
            ->select('COUNT(r.id)');

        $this->applyFilters($qb, $filters);

        if ($startDate !== null) {
            $qb->andWhere('r.created_at >= :startDate')
                ->setParameter('startDate', $startDate);
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function findWithFilters(array $filters = [], \DateTimeInterface $startDate = null): array
    {
        $qb = $this->createQueryBuilder('r')
            ->orderBy('r.created_at', 'DESC');

        $this->applyFilters($qb, $filters);

        if ($startDate) {
            $qb->andWhere('r.created_at >= :startDate')
                ->setParameter('startDate', $startDate);
        }

        return $qb->getQuery()->getResult();
    }

    private function applyFilters(QueryBuilder $qb, array $filters): void
    {
        if (isset($filters['type'])) {
            $qb->andWhere('r.typeRapport = :type')
                ->setParameter('type', $filters['type']);
        }

        if (isset($filters['user'])) {
            $qb->join('r.created_by', 'u')
                ->andWhere('u.email = :email')
                ->setParameter('email', $filters['user']);
        }

        if (isset($filters['structure'])) {
            $qb->join('r.dossier', 'd')
                ->join('d.structure', 's')
                ->andWhere('s.name = :structure')
                ->setParameter('structure', $filters['structure']);
        }
    }

    public function getTypesDistribution(array $filters = []): array
    {
        $qb = $this->createQueryBuilder('r')
            ->select('r.typeRapport as type, COUNT(r.id) as count')
            ->groupBy('r.typeRapport');

        $this->applyFilters($qb, $filters);

        $results = $qb->getQuery()->getResult();
        
        $distribution = [];
        foreach ($results as $result) {
            $distribution[$result['type']] = $result['count'];
        }

        return $distribution;
    }

    public function findDistinctTypes(): array
    {
        return $this->createQueryBuilder('r')
            ->select('DISTINCT r.typeRapport')
            ->getQuery()
            ->getSingleColumnResult();
    }
}