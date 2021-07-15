<?php

namespace App\Repository;

use App\Entity\Municipalite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Municipalite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Municipalite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Municipalite[]    findAll()
 * @method Municipalite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MunicipaliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Municipalite::class);
    }

    // /**
    //  * @return Municipalite[] Returns an array of Municipalite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Municipalite
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
