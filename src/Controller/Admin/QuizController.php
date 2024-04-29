<?php

namespace App\Controller\Admin;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use App\Repository\QuestionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;

class QuizController extends AbstractController
{
    public function index(QuizRepository $quizRepository): Response
    {
        $quizzes = $quizRepository->findAll(); 

        return $this->render('admin/quiz/index.html.twig', [
            'quizzes' => $quizzes,
        ]);
    }

    public function view($id, QuizRepository $quizRepository, QuestionsRepository $questionsRepository): Response
    {
        $quiz = $quizRepository->find($id); 
        $questions = $questionsRepository->findBy(['quizId' => $id]); 

        return $this->render('admin/quiz/view.html.twig', [
            'quiz' => $quiz,
            'questions' => $questions,
        ]);
    }

    public function delete(ManagerRegistry $manager, $id, QuizRepository $quizRepository): Response
    {
        $quiz = $quizRepository->find($id); 
        $entityManager = $manager->getManager();
        $entityManager->remove($quiz);
        $entityManager->flush();

        return $this->redirectToRoute('admin_quiz_index'); 
    }
}
