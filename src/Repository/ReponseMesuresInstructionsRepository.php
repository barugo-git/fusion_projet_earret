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

//    /**
//     * @return ReponseMesuresInstructions[] Returns an array of ReponseMesuresInstructions objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReponseMesuresInstructions
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
