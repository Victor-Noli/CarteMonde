<?php

namespace App\Repository;

use App\Entity\JWT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method JWT|null find($id, $lockMode = null, $lockVersion = null)
 * @method JWT|null findOneBy(array $criteria, array $orderBy = null)
 * @method JWT[]    findAll()
 * @method JWT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JWTRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JWT::class);
    }

    // /**
    //  * @return JWT[] Returns an array of JWT objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JWT
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
