<?php

namespace App\Repository;

use App\Entity\Questions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Questions>
 *
 * @method Questions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Questions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Questions[]    findAll()
 * @method Questions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Questions::class);
    }

    // Here you can add custom repository methods, for example:
    
    /**
     * @return Questions[] Returns an array of Questions objects filtered by some criteria
     */
    // public function findBySomeField($value): array
    // {
    //     return $this->createQueryBuilder('q')
    //         ->andWhere('q.someField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('q.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    /**
     * @return Questions|null Finds a single Questions entity by some condition
     */
    // public function findOneBySomeField($value): ?Questions
    // {
    //     return $this->createQueryBuilder('q')
    //         ->andWhere('q.someField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
}
