<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    
    public function index(CoursRepository $coursRepository): Response
    {

        $lastThreeCourses = $coursRepository->findLastThreeCourses();

        return $this->render('home/main/index.html.twig', [
            'lastThreeCourses' => $lastThreeCourses,
        ]);
    }
}
