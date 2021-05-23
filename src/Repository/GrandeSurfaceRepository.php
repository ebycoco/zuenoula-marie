<?php

namespace App\Repository;

use App\Entity\GrandeSurface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GrandeSurface|null find($id, $lockMode = null, $lockVersion = null)
 * @method GrandeSurface|null findOneBy(array $criteria, array $orderBy = null)
 * @method GrandeSurface[]    findAll()
 * @method GrandeSurface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GrandeSurfaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GrandeSurface::class);
    }

    // /**
    //  * @return GrandeSurface[] Returns an array of GrandeSurface objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GrandeSurface
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
