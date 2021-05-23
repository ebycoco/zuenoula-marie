<?php

namespace App\Repository;

use App\Entity\ImageSport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageSport|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageSport|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageSport[]    findAll()
 * @method ImageSport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageSportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageSport::class);
    }

    // /**
    //  * @return ImageSport[] Returns an array of ImageSport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageSport
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
