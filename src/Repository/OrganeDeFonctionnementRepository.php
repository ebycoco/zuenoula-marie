<?php

namespace App\Repository;

use App\Entity\OrganeDeFonctionnement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrganeDeFonctionnement|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrganeDeFonctionnement|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrganeDeFonctionnement[]    findAll()
 * @method OrganeDeFonctionnement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganeDeFonctionnementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrganeDeFonctionnement::class);
    }

    // /**
    //  * @return OrganeDeFonctionnement[] Returns an array of OrganeDeFonctionnement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrganeDeFonctionnement
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
