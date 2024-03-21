<?php

namespace App\Controller\Quiz;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    
    public function index(): Response
    {
        return $this->render('home/quiz/index.html.twig', [
            'controller_name' => 'QuizController',
        ]);
    }

    public function note(): Response
    {
        return $this->render('home/quiz/note.html.twig', [
            'controller_name' => 'QuizController',
        ]);
    }
}
