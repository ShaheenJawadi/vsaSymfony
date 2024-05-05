<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    public function findLastThreeCourses(): array
    {
        return $this->findAll();
    }
 
    public function findBySearchTerm($searchTerm, $limit, $offset)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.nom LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function countBySearchTerm($searchTerm)
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->andWhere('c.nom LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->getQuery()
            ->getSingleScalarResult();
    }

}
