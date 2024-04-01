<?php

namespace App\Controller\Cours;

use App\Repository\AvisRepository;
use App\Repository\CoursRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoursController extends AbstractController
{
    
    public function coursPage(string $slug ,AvisRepository $repo): Response
    {
      
        $avis = $repo->getAll(); // Récupérer la liste des avis depuis le repository
        return $this->render('home/cours/single/index.html.twig', [
            'controller_name' => 'CoursController',
            'avis' => $avis, // Transmettre la variable "avis" au fichier Twig

        ]);
    }
    public function coursLessonsPage(): Response
    {
       
        return $this->render('home/cours/lessons/index.html.twig', [
            
        ]);
    }
}
