<?php

namespace App\Repository;

use App\Entity\ShortenUrl;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Result;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShortenUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShortenUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShortenUrl[]    findAll()
 * @method ShortenUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortenUrlRepository extends ServiceEntityRepository
{
    private Connection $conn;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, ShortenUrl::class);
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
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function getAll(int $userId): ?array
    {
        $conn = $this->getConnection();

        if ($userId <= 0 || $conn === null) {
            return null;
        }

        $sql = '
        select pu.url as publicUrl, t.url as shortenUrl
            from shorten_url s_u
                     join public_url pu on pu.id = s_u.publicurl_id
                     join token t on s_u.token_id = t.id
            where t.user_id = :us
            order by s_u.id desc
        ';
        try {
            $stmt = $conn->prepare($sql);
            //$stmt->bindParam(1, $userId);
            $result = $stmt->executeQuery(['us' => $userId]);

            return $result->fetchAllAssociative();
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @param int $tokenId
     * @param int $publicUrlId
     * @param int $statusId
     * @return Result|null
     */
/*    public function insert(int $tokenId, int $publicUrlId, int $statusId): ?int
    {
        $conn = $this->getConnection();
        if ($tokenId <= 0 || $publicUrlId <= 0 || $statusId <= 0 ||  $conn === null) {
            return null;
        }

        try{
            $sql = '
                insert into shorten_url(token_id, publicurl_id, status_id) 
                value(:tokenId, :publicUrlId, :statusId)';
            $stmt = $conn->prepare($sql);
            $stmt->executeQuery(
                ['tokenId' => $tokenId, 'publicUrlId' => $publicUrlId, 'statusId' => $statusId]);

            return $this->conn->lastInsertId();
        }catch (Exception | \Doctrine\DBAL\Driver\Exception $e){
            var_dump($e->getMessage());
            return null;
        }
    }*/

    public function getById(int $tokenId)
    {

    }

    // /**
    //  * @return ShortenUrl[] Returns an array of ShortenUrl objects
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
    public function findOneBySomeField($value): ?ShortenUrl
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
