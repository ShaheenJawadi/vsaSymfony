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
        return $this->createQueryBuilder('c') 
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
 
}
