<?php

namespace App\Repository;

use App\Entity\LigneDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<LigneDocument>
 */
class LigneDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, LigneDocument::class);
        $this->mr = $registry;
        $this->entityManager = $this->mr->getManager();
        $this->em = $em;
        $this->rsm = new ResultSetMapping();
    }

    public function findLigneDocumentByClient($client): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\LigneDocument', 'ld');
        $rsm->addFieldResult('ld', 'id', 'id');
        $rsm->addFieldResult('ld', 'libelle', 'libelle');
        $rsm->addFieldResult('ld', 'id_machine', 'id');
        $rsm->addFieldResult('ld', 'libelle_machine', 'libelle');

        $query = $this->_em->createNativeQuery('SELECT p.*,m.id as id_machine,m.libelle as libelle_machine FROM poste p left join machine_poste mp on mp.poste_id=p.id left join machine m on mp.machine_id=m.id', $rsm);
        return $query->getArrayResult();
    }
    //    /**
    //     * @return LigneDocument[] Returns an array of LigneDocument objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?LigneDocument
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
