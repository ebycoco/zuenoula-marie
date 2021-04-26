<?php

namespace App\Repository;

use App\Entity\Motmaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Motmaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Motmaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Motmaire[]    findAll()
 * @method Motmaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotmaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Motmaire::class);
    }

    // /**
    //  * @return Motmaire[] Returns an array of Motmaire objects
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
    public function findOneBySomeField($value): ?Motmaire
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
