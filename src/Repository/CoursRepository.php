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
 
    public function findBySearchTermAndSubCategory($searchTerm, $subCategory, $limit, $offset)
    {
        $queryBuilder = $this->createQueryBuilder('c');

        if ($searchTerm) {
            $queryBuilder
                ->andWhere('c.nom LIKE :searchTerm')
                ->setParameter('searchTerm', '%'.$searchTerm.'%');
        }

        if ($subCategory) {
            $queryBuilder
                ->andWhere('c.subcategoryid  = :subCategory')
                ->setParameter('subCategory', $subCategory);
        }

        return $queryBuilder
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function countBySearchTermAndSubCategory($searchTerm, $subCategory)
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)');

        if ($searchTerm) {
            $queryBuilder
                ->andWhere('c.nom LIKE :searchTerm')
                ->setParameter('searchTerm', '%'.$searchTerm.'%');
        }

        if ($subCategory) {
            $queryBuilder
                ->andWhere('c.subcategoryid  = :subCategory')
                ->setParameter('subCategory', $subCategory);
        }

        return $queryBuilder
            ->getQuery()
            ->getSingleScalarResult();
    }
}
