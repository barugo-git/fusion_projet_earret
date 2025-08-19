<?php

namespace App\Repository;

use App\Entity\ConseillerPartie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConseillerPartie>
 *
 * @method ConseillerPartie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConseillerPartie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConseillerPartie[]    findAll()
 * @method ConseillerPartie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConseillerPartieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConseillerPartie::class);
    }

    public function add(ConseillerPartie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConseillerPartie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConseillerPartieDefendeur[] Returns an array of ConseillerPartieDefendeur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ConseillerPartieDefendeur
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
