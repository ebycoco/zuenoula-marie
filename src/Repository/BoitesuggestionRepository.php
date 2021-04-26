<?php

namespace App\Repository;

use App\Entity\Boitesuggestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Boitesuggestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boitesuggestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boitesuggestion[]    findAll()
 * @method Boitesuggestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoitesuggestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Boitesuggestion::class);
    }

    // /**
    //  * @return Boitesuggestion[] Returns an array of Boitesuggestion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Boitesuggestion
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
