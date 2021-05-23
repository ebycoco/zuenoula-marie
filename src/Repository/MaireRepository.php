<?php

namespace App\Repository;

use App\Entity\Maire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Maire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Maire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Maire[]    findAll()
 * @method Maire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Maire::class);
    }

    // /**
    //  * @return Maire[] Returns an array of Maire objects
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
    public function findOneBySomeField($value): ?Maire
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
