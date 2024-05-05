<?php

namespace App\Controller\Cours;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FilterController extends AbstractController
{
    
    public function index(CoursRepository $coursRepository , Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 1;   
        $offset = ($page - 1) * $limit; 
        $data = $coursRepository->findBy([], null, $limit, $offset);
        $totalItems = $coursRepository->count([]);
        $totalPages = ceil($totalItems / $limit);

         
 
        return $this->render('home/cours/filter/index.html.twig', [
            'data' => $data,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }
}
