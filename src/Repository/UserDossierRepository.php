<?php

namespace App\Repository;

use App\Entity\UserDossier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserDossier>
 *
 * @method UserDossier|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserDossier|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserDossier[]    findAll()
 * @method UserDossier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDossierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserDossier::class);
    }

    public function add(UserDossier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserDossier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserDossier[] Returns an array of UserDossier objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findAllDossierenAttente()
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.dossier','d')
            ->andWhere('d.etatDossier = :val')
            ->setParameter('val', "OUVERT")
            ->getQuery()
            ->getResult()
        ;
    }
}
