<?php

namespace App\Controller\Quiz;

use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class QuizController extends AbstractController
{
    public function index(Request $request, QuizRepository $quizRepository, int $coursId, int $questionIndex): Response
{
    // Check if the request contains a parameter for the next question index
    $nextQuestionIndex = $request->query->getInt('nextQuestionIndex', $questionIndex + 1);

    $quiz = $this->getQuizByCoursId($coursId, $quizRepository);
    $questionDetails = $this->fetchQuestionDetails($quizRepository, $coursId, $nextQuestionIndex);

    return $this->render('home/quiz/index.html.twig', [
        'controller_name' => 'QuizController',
        'questionDetails' => $questionDetails,
        'quizz' => $quiz,
        'questionIndex'=>$nextQuestionIndex
    ]);

}

    private function fetchQuestionDetails(QuizRepository $quizRepository, int $coursId, int $questionIndex)
    {
        $quizzes = $this->getQuizByCoursId($coursId, $quizRepository);

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

    private function getQuizByCoursId(int $coursId, QuizRepository $quizRepository)
    {
        return $quizRepository->findQuizByCoursId($coursId);
    }

    public function note(): Response
    {
        return $this->render('home/quiz/note.html.twig', [
            'controller_name' => 'QuizController',
        ]);
    }
}
