<?php

namespace App\Repository;

use App\Entity\PublicUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PublicUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicUrl[]    findAll()
 * @method PublicUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublicUrl::class);
    }

    // /**
    //  * @return PublicUrl[] Returns an array of PublicUrl objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PublicUrl
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
