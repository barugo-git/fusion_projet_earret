<?php

namespace App\Repository;

use App\Entity\MesuresInstructions;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MesuresInstructions>
 *
 * @method MesuresInstructions|null find($id, $lockMode = null, $lockVersion = null)
 * @method MesuresInstructions|null findOneBy(array $criteria, array $orderBy = null)
 * @method MesuresInstructions[]    findAll()
 * @method MesuresInstructions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MesuresInstructionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MesuresInstructions::class);
    }

    public function add(MesuresInstructions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MesuresInstructions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MesuresInstructions[] Returns an array of MesuresInstructions objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MesuresInstructions
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function mesuresInstructionParAvocatParDossier()
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.dossier','d')

            ->getQuery()
            ->getResult()
        ;
    }

    public function findByGreffier(User $greffier): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.greffier = :greffier')
            ->setParameter('greffier', $greffier->getId()->toBinary())
            ->getQuery()
            ->getResult();
    }
}
