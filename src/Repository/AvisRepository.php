<?php

namespace App\Repository;

use App\Entity\Avis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AvisRepository extends ServiceEntityRepository
{
    /**
    * @method Avis[]    findAll()
    */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avis::class);
    }

    // Ajoutez vos méthodes personnalisées ici
    public function getAll(): array
    {
        return $this->findAll();
    }
    public function getAvisByNote(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.note', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function findAvisByCoursId(int $coursId): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.coursid = :coursId')
            ->setParameter('coursId', $coursId)
            ->getQuery()
            ->getResult();
    }
    public function findAvisById(int $id): ?Avis
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
}
