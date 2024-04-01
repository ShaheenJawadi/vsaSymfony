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

    public function findDistinctContributors()
    {
            $em = $this->getEntityManager();
            $connection = $em->getConnection();

            $sql = "
                SELECT DISTINCT u.username AS username, u.image AS image FROM publications p
                JOIN user u ON p.user_id = u.id
                UNION
                SELECT DISTINCT u.username, u.image FROM commentaires c
                JOIN user u ON c.user_id = u.id
            ";

            $stmt = $connection->executeQuery($sql);

            return $stmt->fetchAllAssociative();
    }

    public function findPublicationWithUserDetails(int $publicationId): ?Publications
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.user', 'u')
            ->addSelect('u')
            ->leftJoin('p.commentaires', 'c')
            ->addSelect('c')
            ->where('p.id = :publicationId') 
            ->setParameter('publicationId', $publicationId)
            ->getQuery()
            ->getOneOrNullResult(); 
    }
    public function findPubByUserId($userId): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.user', 'u')
            ->addSelect('u')
            ->leftJoin('p.commentaires', 'c')
            ->addSelect('c')
            ->where('u.id = :userId') 
            ->setParameter('userId', $userId)
            ->orderBy('p.dateCreation', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllPublicationsOrderedByClicks(): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.user', 'u')
            ->addSelect('u')
            ->leftJoin('p.commentaires', 'c')
            ->addSelect('c')
            ->orderBy('p.nbclicks', 'DESC') 
            ->getQuery()
            ->getResult();
    }
    public function findExistingPublication($userId, $titre, $contenu)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.user', 'u')
            ->where('u.id = :userId')
            ->andWhere('p.titre = :titre')
            ->andWhere('p.contenu = :contenu')
            ->setParameter('userId', $userId)
            ->setParameter('titre', $titre)
            ->setParameter('contenu', $contenu)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function findAllPublicationsOrderedByJaime(): array
    {
        
        $qb = $this->createQueryBuilder('p')
            ->select('p', 'SUM(r.jaime) AS HIDDEN jaimeSum') 
            ->leftJoin('App\Entity\Reactions', 'r', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.pub = p.id') 
            ->groupBy('p.id') 
            ->orderBy('jaimeSum', 'DESC'); 

        return $qb->getQuery()->getResult();
    }
    public function findAllPublicationsOrderedByDislike(): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p', 'SUM(r.dislike) AS HIDDEN dislikeSum') 
            ->leftJoin('App\Entity\Reactions', 'r', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.pub = p.id') 
            ->groupBy('p.id') 
            ->orderBy('dislikeSum', 'DESC'); 
        return $qb->getQuery()->getResult();
    }
}