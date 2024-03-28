<?php

namespace App\Repository;

use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quiz>
 *
 * @method Quiz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quiz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quiz[]    findAll()
 * @method Quiz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    
    /**
     * @param int $coursId The ID of the cours to find quizzes for
     * @return Quiz[] Returns an array of Quiz objects
     */
    public function findQuizByCoursId(int $coursId): array
    {
        return $this->createQueryBuilder('q')
            ->leftJoin('q.questions', 'questions') // Assume 'questions' is the property name in Quiz entity for Questions association
            ->leftJoin('questions.suggestions', 'suggestions') // Assume 'suggestions' is the property name in Questions entity for Suggestion association
            ->addSelect('questions', 'suggestions') // Select the joined entities as well
            ->andWhere('q.coursid = :val')
            ->setParameter('val', $coursId)
            ->getQuery()
            ->getResult();
    }
    

}
