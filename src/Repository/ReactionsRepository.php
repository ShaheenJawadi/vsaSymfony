<?php

namespace App\Repository;

use App\Entity\Reactions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @extends ServiceEntityRepository<Reactions>
 *
 * @method Reactions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reactions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reactions[]    findAll()
 * @method Reactions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReactionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reactions::class);
    }

    /**
     * Fetches the sum of jaime and dislike for each publication.
     * 
     * @return array
     */
    public function findReactionsSummary(): array
    {
        $qb = $this->createQueryBuilder('r')
            ->select('IDENTITY(r.pub) as pubId', 'SUM(r.jaime) as totalJaime', 'SUM(r.dislike) as totalDislike')
            ->groupBy('r.pub');

        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function findReactionsSummaryByPubId($pubId)
    {
        $qb = $this->createQueryBuilder('r')
            ->select('SUM(r.jaime) AS totalJaime', 'SUM(r.dislike) AS totalDislike')
            ->where('r.pub = :pubId')
            ->setParameter('pubId', $pubId)
            ->groupBy('r.pub');

        $result = $qb->getQuery()->getOneOrNullResult();

        // Return a default structure if no reactions are found
        if (!$result) {
            return ['likes' => 0, 'dislikes' => 0];
        }

        // Assuming the 'jaime' and 'dislike' fields are stored as integers in the database.
        // This ensures that the return values are integers even if the database fields allow nulls.
        return [
            'likes' => (int) $result['totalJaime'],
            'dislikes' => (int) $result['totalDislike'],
        ];
    }
}
