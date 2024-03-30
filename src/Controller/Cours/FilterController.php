<?php

namespace App\Controller\Cours;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilterController extends AbstractController
{
    
    public function index(CoursRepository $coursRepository): Response
    {
        $list_cours = $coursRepository->findAll();
        return $this->render('home/cours/filter/index.html.twig', [
            'list_cours' => $list_cours ,
        ]);
    }
}
