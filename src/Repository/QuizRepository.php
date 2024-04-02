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
    public function findQuizByCoursId(int $coursId, int $userId): array
    {
        return $this->createQueryBuilder('q')
            ->leftJoin('q.questions', 'questions')
            ->leftJoin('questions.suggestions', 'suggestions')
            ->addSelect('questions', 'suggestions')
            ->andWhere('q.coursid = :coursId')
            ->andWhere('q.userid = :userId') // Assuming direct association for simplicity
            ->setParameter('coursId', $coursId)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }


    public function getQuizById(int $idQuiz): ?Quiz
    {
        return $this->createQueryBuilder('q')
            ->leftJoin('q.coursid', 'cours')
            ->leftJoin('q.questions', 'questions')
            ->leftJoin('questions.suggestions', 'suggestions')
            ->addSelect('cours', 'questions', 'suggestions')
            ->andWhere('q.id = :id')
            ->setParameter('id', $idQuiz)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getAllQuizzesWithDetails(int $userId): array
    {
        return $this->createQueryBuilder('q')
            ->leftJoin('q.coursid', 'cours')
            ->leftJoin('q.questions', 'questions')
            ->leftJoin('questions.suggestions', 'suggestions')
            ->addSelect('cours', 'questions', 'suggestions')
            ->andWhere('q.userid = :userId') // Filter by userid
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }


    

}
