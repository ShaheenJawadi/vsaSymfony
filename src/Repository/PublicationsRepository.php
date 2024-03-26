<?php

namespace App\Repository;

use App\Entity\Publications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Publications>
 *
 * @method Publications|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publications|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publications[]    findAll()
 * @method Publications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publications::class);
    }

  /**
     * Fetch all publications with user details.
     *
     * @return array An array of Publications objects with user details
     */
    public function findAllPublicationsWithUserDetails(): array
    {
        return $this->createQueryBuilder('p')
        ->innerJoin('p.user', 'u')
        ->addSelect('u')
        ->leftJoin('p.commentaires', 'c')
        ->addSelect('c')
        ->orderBy('p.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();
    }

    // More custom methods can be added as needed
}
