<?php

namespace App\Repository;

use App\Entity\AdministrationDeMunicipalite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdministrationDeMunicipalite|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdministrationDeMunicipalite|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdministrationDeMunicipalite[]    findAll()
 * @method AdministrationDeMunicipalite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdministrationDeMunicipaliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdministrationDeMunicipalite::class);
    }

    // /**
    //  * @return AdministrationDeMunicipalite[] Returns an array of AdministrationDeMunicipalite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdministrationDeMunicipalite
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
