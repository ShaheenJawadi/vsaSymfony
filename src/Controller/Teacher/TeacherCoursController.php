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

  

    public function add(): Response
    {
        return $this->render('teacher/cours/add/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

    public function add_lesson( ): Response
    {
        $content = $this->renderView('teacher/components/cours/single_lesson_form.html.twig');

        return new Response($content);
      
    }


    public function create(): Response
    {
         ////
    }


}
