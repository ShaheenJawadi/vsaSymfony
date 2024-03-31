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

            // Execute the native query and get a Result object
            $stmt = $connection->executeQuery($sql);

            // Fetch and return results
            return $stmt->fetchAllAssociative();
    }

    /**
     * Fetch a publication by ID with user and comments details.
     *
     * @param int $publicationId The ID of the publication to fetch.
     * @return Publications|null The Publications object with user and comments details or null if not found.
     */
    public function findPublicationWithUserDetails(int $publicationId): ?Publications
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.user', 'u')
            ->addSelect('u')
            ->leftJoin('p.commentaires', 'c')
            ->addSelect('c')
            ->where('p.id = :publicationId') // Filter by publication ID
            ->setParameter('publicationId', $publicationId)
            ->getQuery()
            ->getOneOrNullResult(); // Use getOneOrNullResult() since we're fetching by ID
    }
    public function findPubByUserId($userId): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.user', 'u')
            ->addSelect('u')
            ->leftJoin('p.commentaires', 'c')
            ->addSelect('c')
            ->where('u.id = :userId') // Filter by user ID
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
            ->orderBy('p.nbclicks', 'DESC') // Order by 'nbClicks' in descending order
            ->getQuery()
            ->getResult();
    }

}