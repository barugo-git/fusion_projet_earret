<?php

namespace App\Repository;

use App\Entity\DossierPiecesJointes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DossierPiecesJointes>
 *
 * @method DossierPiecesJointes|null find($id, $lockMode = null, $lockVersion = null)
 * @method DossierPiecesJointes|null findOneBy(array $criteria, array $orderBy = null)
 * @method DossierPiecesJointes[]    findAll()
 * @method DossierPiecesJointes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossierPiecesJointesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DossierPiecesJointes::class);
    }

    public function add(DossierPiecesJointes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DossierPiecesJointes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DossierPiecesJointes[] Returns an array of DossierPiecesJointes objects
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

//    public function findOneBySomeField($value): ?DossierPiecesJointes
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
