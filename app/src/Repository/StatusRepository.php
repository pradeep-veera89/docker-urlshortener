<?php

namespace App\Repository;

use App\Entity\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Status|null find($id, $lockMode = null, $lockVersion = null)
 * @method Status|null findOneBy(array $criteria, array $orderBy = null)
 * @method Status[]    findAll()
 * @method Status[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusRepository extends ServiceEntityRepository
{

    public const ACTIVE = 'active';
    public const BLOCKED = 'blocked';
    public const EXPIRED = 'expired';
    public const NEW = 'new';
    private Connection $conn;

    /**
     * @param ManagerRegistry $registry
     * @param EntityManager $entityManager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface  $entityManager)
    {
        parent::__construct($registry, Status::class);
        $this->conn = $entityManager->getConnection();
    }

    /**
     * @return Connection|null
     */
    private function getConnection(): ?Connection
    {
        if(isset($this->conn)) {
            return $this->conn;
        }
        return null;
    }

    /**
     * @return string[]
     */
    public function getNamesAsArray()
    {
        return [self::ACTIVE, self::BLOCKED, self::EXPIRED, self::NEW];
    }

    /**
     * @param string $status
     * @return int|null
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function get(string $status):?int
    {
        $conn = $this->getConnection();
        if(!in_array($status, $this->getNamesAsArray()) || $conn === null) {
            return null;
        }
        $sql = '
            SELECT id 
            FROM status
            WHERE name = :status_name';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery(['status_name'=> $status])->fetchFirstColumn();
        if(isset($result['id']) && $result['id'] > 0) {
            return $result['id'];
        }
        return null;
    }

    public function findByName(string $name):?Status
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    // /**
    //  * @return Status[] Returns an array of Status objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Status
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
