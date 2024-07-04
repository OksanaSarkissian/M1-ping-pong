<?php

namespace App\Repository;

use App\Entity\Achat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Achat>
 */
class AchatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        $this->mr = $registry;
        $this->entityManager = $this->mr->getManager();
        $this->em = $em;
        $this->rsm = new ResultSetMapping();
        parent::__construct($registry, Achat::class);
    }

    public function findAllByDate($date){
        return $this->createQueryBuilder('a')
        ->andWhere('MONTH(a.date) = MONTH(:date) AND YEAR(a.date) = YEAR(:date)')
        ->setParameter('date', $date)
        ->getQuery()
        ->getArrayResult()
    ;
    }
    //    /**
    //     * @return Achat[] Returns an array of Achat objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Achat
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
