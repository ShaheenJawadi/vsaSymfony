<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // Here you can add custom repository methods, for example:
    
    /**
     * @return User[] Returns an array of User objects filtered by some criteria
     */
    // public function findBySomeField($value): array
    // {
    //     return $this->createQueryBuilder('u')
    //         ->andWhere('u.someField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('u.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    /**
     * @return User|null Finds a single User entity by some condition
     */
    // public function findOneBySomeField($value): ?User
    // {
    //     return $this->createQueryBuilder('u')
    //         ->andWhere('u.someField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }

    /**
     * Finds a single User entity by its ID.
     *
     * @param int $id The ID of the user
     *
     * @return User|null The user entity if found, or null if not found
     */
    public function findById(int $id): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

     /**
     * Finds a single User entity by its email.
     *
     * @param string $email The email of the user
     *
     * @return User|null The user entity if found, or null if not found
     */
    public function findByEmail(string $email): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }


/**
 * Finds a single User entity by its username.
 *
 * @param string $username The username of the user
 *
 * @return User|null The user entity if found, or null if not found
 */
public function findByUsername(string $username): ?User
{
    return $this->createQueryBuilder('u')
        ->andWhere('u.username = :username')
        ->setParameter('username', $username)
        ->getQuery()
        ->getOneOrNullResult();
}
}
