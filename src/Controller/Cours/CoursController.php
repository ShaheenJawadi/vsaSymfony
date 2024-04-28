<?php

namespace App\Controller\Cours;

use App\Repository\AvisRepository;
use App\Repository\CoursRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoursController extends AbstractController
{
    
    public function coursPage(string $slug ,AvisRepository $repo,CoursRepository $coursRepo): Response
    {
      
        $avis = $repo->getAll(); 
        $singleCours = $coursRepo->findOneBy(['slug' => $slug]);
        $averageNote = $repo->getAverageNote();
        $countByNote = [
            5 => $repo->getCountByNote(5),
            4 => $repo->getCountByNote(4),
            3 => $repo->getCountByNote(3),
            2 => $repo->getCountByNote(2),
            1 => $repo->getCountByNote(1),
        ]; 
 
      
        return $this->render('home/cours/single/index.html.twig', [
            'controller_name' => 'CoursController',
            'singleCours'=>$singleCours ,
            'avis' => $avis,  
            'averageNote' => $averageNote, 
            'countByNote' => $countByNote,
        ]);
    }
    public function coursLessonsPage(): Response
    {
       
        return $this->render('home/cours/lessons/index.html.twig', [
            
        ]);
    }
}
