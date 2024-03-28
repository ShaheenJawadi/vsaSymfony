<?php

namespace App\Controller\Teacher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 

class TeacherController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('teacher/dashboard/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

  

    public function students_page(): Response
    {
        return $this->render('teacher/students/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }
}
