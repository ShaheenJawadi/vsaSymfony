<?php

namespace App\Controller\Quiz;

use App\Entity\Notes;
use App\Entity\Quiz;
use App\Entity\User;
use App\Repository\NotesRepository;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\UserRepository;


use Doctrine\Persistence\ManagerRegistry;

class QuizController extends AbstractController
{
    public function index(Request $request, QuizRepository $quizRepository, UserRepository $userRepository): Response
    {$user = $userRepository->find(18); // FIXME: userid=18
        if (!$user) {
            throw $this->createNotFoundException('No user found for id 18');
        }

        $userId = $user->getId();
        $coursId=2;   
        $questionIndex = $request->attributes->get('questionIndex'); // Extract questionIndex from the route
    
        // If for some reason questionIndex is not found, default to 0
        if ($questionIndex === null) {
            $questionIndex = 0;
        } else {
            $questionIndex = (int) $questionIndex; // Ensure questionIndex is an integer
        } 
    $quiz = $this->getQuizByCoursId($coursId, $quizRepository,$userId);
    $questionDetails = $this->fetchQuestionDetails($quizRepository, $coursId, $questionIndex,$userId);

    return $this->render('home/quiz/index.html.twig', [
        'controller_name' => 'QuizController',
        'questionDetails' => $questionDetails,
        'quizz' => $quiz,
    ]);

}

    private function fetchQuestionDetails(QuizRepository $quizRepository, int $coursId, int $questionIndex,int $userId)
    {
        $quizzes = $this->getQuizByCoursId($coursId, $quizRepository,$userId);

        if (empty($quizzes)) {
            return null;
        }

        $quiz = $quizzes[0]; // Assuming using the first quiz
        $questions = $quiz->getQuestions();

        if ($questionIndex < 0 || $questionIndex >= count($questions)) {
            return null;
        }

        $currentQuestion = $questions[$questionIndex];
        $isLastQuestion = ($questionIndex + 1 === count($questions));

        return [
            'quiz' => $quiz,
            'currentQuestion' => $currentQuestion,
            'currentQuestionIndex' => $questionIndex,
            'isLastQuestion' => $isLastQuestion,
            'totalQuestions' => count($questions),
        ];
    }

    private function getQuizByCoursId(int $coursId, QuizRepository $quizRepository, int $userId)
    {
        
        return $quizRepository->findQuizByCoursId($coursId,$userId);
    }

    public function note(Request $request): Response
    {
        $session = $request->getSession();
        $score = $session->get('quizScore', 'Not available');
        
        // Remove the score from the session if you don't need it anymore
        $session->remove('quizScore');
    
        return $this->render('home/quiz/note.html.twig', [
            'score' => $score,
        ]);
    }
     public function submitQuizScore(Request $request, ManagerRegistry $manager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $score = $data['score'];
        $quizId = $data['quizId'];
        $userId = $data['userId'];

        $em = $manager->getManager();

        // Find the specific user and quiz
        $user = $em->getRepository(User::class)->find($userId);
        $quiz = $em->getRepository(Quiz::class)->find($quizId);

        if (!$user || !$quiz) {
            return new JsonResponse(['status' => 'error', 'message' => 'User or quiz not found'], 404);
        }

        // Check if a note already exists for this user and quiz
        $note = $em->getRepository(Notes::class)->findOneBy(['userid' => $user, 'quizid' => $quiz]);

        // If no note exists, create a new one
        if (!$note) {
            $note = new Notes();
            $note->setUserid($user);
            $note->setQuizid($quiz);
        }

        // Set or update the score
        $note->setNote($score);

        // Persist and flush the note entity
        $em->persist($note);
        $em->flush();

        $session = $request->getSession();
        $session->set('quizScore', $score);

        // Return the success response
        return new JsonResponse(['status' => 'success']);
    }

}
