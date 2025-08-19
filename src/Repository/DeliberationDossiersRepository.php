<?php

namespace App\Repository;

use App\Entity\DeliberationDossiers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeliberationDossiers>
 *
 * @method DeliberationDossiers|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliberationDossiers|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliberationDossiers[]    findAll()
 * @method DeliberationDossiers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliberationDossiersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeliberationDossiers::class);
    }

    public function add(DeliberationDossiers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DeliberationDossiers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DeliberationDossiers[] Returns an array of DeliberationDossiers objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DeliberationDossiers
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
