<?php

namespace App\Controller\Cours;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    
    public function coursPage(): Response
    {
        return $this->render('cours/single/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }

    public function coursLessonsPage(): Response
    {
        return $this->render('cours/lessons/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
