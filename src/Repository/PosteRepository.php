<?php

namespace App\Repository;

use App\Entity\Poste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NativeQuery;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Poste>
 */
class PosteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Poste::class);
        $this->mr = $registry;
        $this->entityManager = $this->mr->getManager();
        $this->em = $em;
        $this->rsm = new ResultSetMapping();
    }

    public function findMachinesByPoste(): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\Poste', 'p');
        $rsm->addFieldResult('p', 'id', 'id');
        $rsm->addFieldResult('p', 'libelle', 'libelle');
        $rsm->addJoinedEntityResult('App\Entity\Machine', 'm', 'p', 'machines');
        $rsm->addFieldResult('m', 'id_machine', 'id');
        $rsm->addFieldResult('m', 'libelle_machine', 'libelle');

        $query = $this->_em->createNativeQuery('SELECT p.*,m.id as id_machine,m.libelle as libelle_machine FROM poste p left join machine_poste mp on mp.poste_id=p.id left join machine m on mp.machine_id=m.id', $rsm);
        return $query->getArrayResult();
    }

    public function findPostesByQualificationUser($user): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\Poste', 'p');
        $rsm->addFieldResult('p', 'id', 'id');
        $rsm->addFieldResult('p', 'libelle', 'libelle');
        // dump($rsm);
        $query = $this->_em->createNativeQuery('SELECT DISTINCT p.*, pu.user_id FROM poste_user pu join poste p on pu.user_id = :user AND pu.poste_id = p.id  ', $rsm);
        $query->setParameter('user', $user);
        return $query->getArrayResult();
    }
    //    /**
//     * @return Poste[] Returns an array of Poste objects
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

    //    public function findOneBySomeField($value): ?Poste
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
