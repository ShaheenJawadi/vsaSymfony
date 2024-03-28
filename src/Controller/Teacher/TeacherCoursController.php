<?php

namespace App\Controller\Teacher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 

class TeacherCoursController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('teacher/cours/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

  
}
