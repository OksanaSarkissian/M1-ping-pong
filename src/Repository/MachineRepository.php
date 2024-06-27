<?php

namespace App\Repository;

use App\Entity\Machine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Machine>
 */
class MachineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        $this->mr = $registry;
        $this->entityManager = $this->mr->getManager();
        $this->em = $em;
        $this->rsm = new ResultSetMapping();
        parent::__construct($registry, Machine::class);
    }

    public function findMachinesByPoste($value): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\Machine', 'm');
        $rsm->addFieldResult('m', 'id', 'id');
        $rsm->addFieldResult('m', 'libelle', 'libelle');

        $query = $this->_em->createNativeQuery('SELECT DISTINCT m.* FROM machine m left join realisation r on r.machine_reel_id = m.id join machine_poste mp on (mp.poste_id = ? AND mp.machine_id = m.id )
', $rsm);
        $query->setParameter(1, "$value");
        return $query->getArrayResult();
    }
    //    /**
    //     * @return Machine[] Returns an array of Machine objects
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

    //    public function findOneBySomeField($value): ?Machine
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
