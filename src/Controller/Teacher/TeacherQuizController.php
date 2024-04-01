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

  

    public function preview(int $quiz_id): Response
    {
        $content = $this->renderView('teacher/components/quiz/preview_popup.html.twig');

        return new Response($content);
      
    }


    public function add(int $cours_id): Response
    {
        return $this->render('teacher/quiz/add/index.html.twig');
    }

    public function add_question(): Response
    {
        $q_index = random_int(10,9999);
        $content = $this->renderView('teacher/components/quiz/single_question_form.html.twig', [
            'q_index'=>$q_index
        ]);

        return new Response($content);
    }
}
