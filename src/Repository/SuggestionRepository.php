<?php

namespace App\Repository;

use App\Entity\Suggestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Suggestion>
 *
 * @method Suggestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Suggestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Suggestion[]    findAll()
 * @method Suggestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuggestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Suggestion::class);
    }

    // Here you can add custom repository methods, for example:
    
    /**
     * @return Suggestion[] Returns an array of Suggestion objects filtered by some criteria
     */
    // public function findBySomeField($value): array
    // {
    //     return $this->createQueryBuilder('s')
    //         ->andWhere('s.someField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('s.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    /**
     * @return Suggestion|null Finds a single Suggestion entity by some condition
     */
    // public function findOneBySomeField($value): ?Suggestion
    // {
    //     return $this->createQueryBuilder('s')
    //         ->andWhere('s.someField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
}
