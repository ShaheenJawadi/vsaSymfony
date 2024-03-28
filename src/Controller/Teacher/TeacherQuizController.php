<?php

namespace App\Controller\Teacher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 

class TeacherQuizController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('teacher/quiz/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

  
}
