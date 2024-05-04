<?php

namespace App\Repository;
use App\Entity\Reclamations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReclamationRepository extends ServiceEntityRepository{
        /**
    * @method Reclamations[]    findAll()
    */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamations::class);
    }
        // Ajoutez vos méthodes personnalisées ici
        public function getAll(): array
        {
            return $this->findAll();
        }
        public function findReclamationById(int $id): ?Reclamations
        {
            return $this->createQueryBuilder('a')
                ->andWhere('a.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
        }
     public function findReclamationByCurrentUserid(int $idUser): array{
        return $this->createQueryBuilder('a')
        ->andWhere('a.idUser = :idUser')
        ->setParameter('idUser', $idUser)
        ->getQuery()
        ->getResult();

     }
     
     public function findUserEmailByUserId(int $userId): ?string
     {
        return $this->createQueryBuilder('r')
        ->select('u.email')
        ->join('r.idUser', 'u')
        ->where('u.id = :userId')
        ->setParameter('userId', $userId)
        ->getQuery()
        ->getSingleScalarResult();
     }
     public function findUserEmailByUserIdAndReclamationId(int $userId, int $reclamationId): ?string
{
    $result = $this->createQueryBuilder('r')
        ->select('u.email')
        ->join('r.idUser', 'u')
        ->where('u.id = :userId')
        ->andWhere('r.idReclamation = :reclamationId')
        ->setParameter('userId', $userId)
        ->setParameter('reclamationId', $reclamationId)
        ->getQuery()
        ->getResult();

    if (!empty($result)) {
        return $result[0]['email'];
    }

    return null;
}
}