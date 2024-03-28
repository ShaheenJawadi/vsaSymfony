<?php

namespace App\Repository;

use App\Entity\Notes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notes>
 *
 * @method Notes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notes[]    findAll()
 * @method Notes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notes::class);
    }

    // Here you can add custom repository methods, for example:
    
    /**
     * @return Notes[] Returns an array of Notes objects filtered by some criteria
     */
    // public function findBySomeField($value): array
    // {
    //     return $this->createQueryBuilder('n')
    //         ->andWhere('n.someField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('n.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    /**
     * @return Notes|null Finds a single Notes entity by some condition
     */
    // public function findOneBySomeField($value): ?Notes
    // {
    //     return $this->createQueryBuilder('n')
    //         ->andWhere('n.someField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
}
