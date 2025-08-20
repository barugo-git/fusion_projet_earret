<?php

namespace App\Repository;

use App\Entity\Dossier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dossier>
 *
 * @method Dossier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dossier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dossier[]    findAll()
 * @method Dossier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dossier::class);
    }

    public function add(Dossier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Dossier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Dossier[] Returns an array of Dossier objects
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

//    public function findOneBySomeField($value): ?Dossier
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }



    public function ListedesDossiersParPeriodet($datedeb,$dateFin)
    {
        $qb = $this->createQueryBuilder('d')
            ->andWhere('d.etatDossier is NULL')
            ->andWhere('d.dateEnregistrement  BETWEEN :from AND :to')
            ->setParameter('from', $datedeb)
            ->setParameter('to', $dateFin)

        ;




        return $qb->getQuery()->getResult();


    }

    public function ListedesDossiersCreeParPeriodet($datedeb,$dateFin)
    {
        $qb = $this->createQueryBuilder('d')
            ->andWhere('d.etatDossier = :etat')
            ->andWhere('d.dateEnregistrement  BETWEEN :from AND :to')
            ->setParameter('from', $datedeb)
            ->setParameter('to', $dateFin)
            ->setParameter('etat',"OUVERT")

        ;




        return $qb->getQuery()->getResult();


    }

    public function recoursAutoriseParGreffierChef($greffier){
        return $this->createQueryBuilder('d')
            ->leftJoin('d.affecterSection','a')
            ->andWhere('d.etatDossier  = :etat')
            ->andWhere('a.greffier = :greffer')
            ->andWhere('d.autorisation = true')
           ->setParameter('greffer', $greffier)
           ->setParameter('etat',"AUTORISATION")
            ->getQuery()
            ->getResult()
            ;
    }

    public function recourstransfererParGreffierChef($greffier){
        return $this->createQueryBuilder('d')
            ->leftJoin('d.affecterUsers','a')
            ->andWhere('d.etatDossier  = :etat')
            ->andWhere('a.destinataire = :greffer')
            ->andWhere('d.autorisation = true')
            ->setParameter('greffer', $greffier->getId()->toBinary())
            ->setParameter('etat',"AUTORISATION")
            ->getQuery()
            ->getResult()
            ;
    }
    /**
         * @return Dossier[] Returns an array of Dossier objects
     */
    public function recoursAffecteParStructure($structure)
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.structures','s')
            ->innerJoin('s.structure','st')
//            ->andWhere('d.etatDossier  = :etat')
            ->andWhere('st.codeStructure = :code')
////            ->setParameter('etat',"AUTORISATION")
            ->setParameter('code',$structure)
            ->getQuery()
            ->getResult()
            ;
    }

    public function dossierAAffecteAuPC()
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.structures','s')
            ->innerJoin('s.structure','st')
            ->innerJoin('d.piecesDoc','p')
            ->andWhere('d.etatDossier  = :etat')
            ->andWhere('st.codeStructure = :code')
            ->andWhere('p.naturePiece= :nature')
            ->setParameter('etat',"CONCLUSION EN COURS")
            ->setParameter('code','PG')
            ->setParameter('nature','RAPPORT AVOCAT GENERAL')
            ->getQuery()
            ->getResult()
            ;
    }

    public function dossierAAffecteAuPG()
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.structures','s')
            ->innerJoin('s.structure','st')
            ->andWhere('d.etatDossier  != :etat')
            ->andWhere('st.codeStructure = :code')
            ->setParameter('etat',"CONCLUSION EN COURS")
            ->setParameter('code','PG')
//            ->setParameter('code',$structure)
            ->getQuery()
            ->getResult()
            ;
    }

    public function recoursAffecteParAG($user){
        return $this->createQueryBuilder('d')

            ->innerJoin('d.mesuresInstructions','m')
            ->innerJoin('d.structures','s')
            ->innerJoin('m.greffier','g')
            ->innerJoin('s.structure','st')
//            ->innerJoin('s.structure','st')
            ->andWhere('g.id  = :user')
            ->andWhere('st.codeStructure = :code')
////            ->setParameter('etat',"AUTORISATION")
            ->setParameter('code','PG')
            ->setParameter('user',$user->getId()->toBinary())
            ->getQuery()
            ->getResult()
            ;
    }
    public function listeGreffierRecours(){
        return $this->createQueryBuilder('d')
            ->leftJoin('d.userDossiers','u')
            ->andWhere('d.etatDossier  = :etat')
            ->andWhere('u.nature = :nature')
            ->andWhere('u.profil = :profil')
            ->setParameter('profil', "GREFFE")
            ->setParameter('etat',"AFFECTE")
            ->setParameter('nature',"AFFECTATION")
            ->getQuery()
            ->getResult()
            ;
    }

    public function listeDossierOuvert(){
        return $this->createQueryBuilder('d')
            ->innerJoin('d.affecterSection','u')
            ->andWhere('d.etatDossier  = :etat')
            ->setParameter('etat',"OUVERT")
//            ->andWhere('d.etatDossier  <> :etat')
//            ->setParameter('etat',Null)
            ->getQuery()
            ->getResult()
            ;
    }

    public function listeDossierOuvertParGreffier($greffier){
        return $this->createQueryBuilder('d')
            ->innerJoin('d.affecterSection','u')
            ->andWhere('d.etatDossier  = :etat')
            ->andWhere('u.greffier = :greffer')
            ->setParameter('greffer', $greffier->getId()->toBinary())
            ->setParameter('etat',"OUVERT")
//            ->andWhere('d.etatDossier  <> :etat')
//            ->setParameter('etat',Null)
            ->getQuery()
            ->getResult()
            ;
    }


    public function listeDossierOuvertEtauRoleParGreffier($greffier)
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.affecterSection', 'u')
            ->andWhere('d.etatDossier =:etat')
            ->orWhere('d.statut =:etat1')// Correction ici : IN doit être avec des parenthèses
            ->andWhere('u.greffier =:greffer')
            ->setParameter('greffer', $greffier->getId()->toBinary())
            ->setParameter('etat', "OUVERT")
            ->setParameter('etat1',"Dossier au Rôle")
            ->orderBy('d.createdAt', 'DESC') // Ajout d'un tri par date
            ->getQuery()
            ->getResult()
            ;
    }


    public function listeDossierPourAvisParties($greffier){
        return $this->createQueryBuilder('d')
            ->innerJoin('d.affecterSection','u')
            ->andWhere('d.etatDossier  = :etat')
            ->andWhere('u.greffier = :greffer')
            ->setParameter('greffer', $greffier->getId()->toBinary())
            ->setParameter('etat',"AVIS GREFFE")
//            ->andWhere('d.etatDossier  <> :etat')
//            ->setParameter('etat',Null)
            ->getQuery()
            ->getResult()
            ;
    }


    public function listeDossierOuvertParConseillerRapporteur($conseilRapporteur){
        return $this->createQueryBuilder('d')
            ->innerJoin('d.affecterSection','u')
            ->andWhere('d.autorisation = true')
            ->andWhere('d.etatDossier  = :etat')
            ->andWhere('u.conseillerRapporteur = :cr')
            ->setParameter('cr', $conseilRapporteur->getId()->toBinary())
            ->setParameter('etat',"OUVERT")
//            ->andWhere('d.etatDossier  <> :etat')
//            ->setParameter('etat',Null)
            ->getQuery()
            ->getResult()
            ;
    }

    public function listeConclusionPGParConseillerRapporteur($conseilRapporteur){
        return $this->createQueryBuilder('d')
            ->innerJoin('d.affecterSection','u')
            ->andWhere('d.autorisation = true')
            ->andWhere('d.etatDossier  = :etat')
            ->andWhere('u.conseillerRapporteur = :cr')
            ->setParameter('cr', $conseilRapporteur->getId()->toBinary())
            ->setParameter('etat',"AVIS CR")
//            ->andWhere('d.etatDossier  <> :etat')
//            ->setParameter('etat',Null)
            ->getQuery()
            ->getResult()
            ;
    }
}
