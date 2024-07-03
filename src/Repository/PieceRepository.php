<?php

namespace App\Repository;

use App\Entity\Piece;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Piece>
 */
class PieceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        $this->mr = $registry;
        $this->entityManager = $this->mr->getManager();
        $this->em = $em;
        $this->rsm = new ResultSetMapping();
        parent::__construct($registry, Piece::class);
    }

    public function findPiecesByIdNotIn($pieces){
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\Piece', 'p');
        $rsm->addFieldResult('p', 'id', 'id');
        $rsm->addFieldResult('p', 'ref_piece', 'ref_piece');
        $rsm->addFieldResult('p', 'libelle_piece', 'libelle_piece');
        $rsm->addFieldResult('p', 'type', 'type');
        $rsm->addFieldResult('p', 'prix_unitaire', 'prix_unitaire');
        $rsm->addFieldResult('p', 'stock', 'stock');

        $qs = 'SELECT p.* FROM piece p where p.type = \'Livrable\'';

        if($pieces) {
            $qs .= 'AND p.id NOT IN (' . $pieces . ')';
        }

        $query = $this->_em->createNativeQuery($qs , $rsm);

        return $query->getArrayResult();
    }
//    /**
//     * @return Piece[] Returns an array of Piece objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Piece
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
