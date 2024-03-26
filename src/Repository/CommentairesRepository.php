<?php

namespace App\Repository;

use App\Entity\Commentaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commentaires>
 *
 * @method Commentaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaires[]    findAll()
 * @method Commentaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaires::class);
    }
    public function findCommentsByPublicationId(int $publicationId): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idPub = :publicationId')
            ->setParameter('publicationId', $publicationId)
            ->orderBy('c.date', 'ASC') // or 'DESC' based on your preference
            ->getQuery()
            ->getResult();
    }

}
