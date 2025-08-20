<?php

namespace App\Repository;

use App\Entity\ReponseMesuresInstructions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReponseMesuresInstructions>
 *
 * @method ReponseMesuresInstructions|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponseMesuresInstructions|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponseMesuresInstructions[]    findAll()
 * @method ReponseMesuresInstructions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseMesuresInstructionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReponseMesuresInstructions::class);
    }

    public function add(ReponseMesuresInstructions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReponseMesuresInstructions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findNonTerminees(): array
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.mesure', 'm') // J'ai corrigé 'mesureInstruction' en 'mesure'
            ->andWhere('r.dateNotification IS NOT NULL')
            ->andWhere('r.reponse IS NULL') // J'ai corrigé 'dateReponse' en 'reponse'
            ->andWhere('m.termine = false')
            ->getQuery()
            ->getResult();
    }
}