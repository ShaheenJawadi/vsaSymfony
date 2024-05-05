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
        $limit = $request->query->getInt('limit', 3);
        $searchTerm = $request->query->get('search');
        $offset = ($page - 1) * $limit;
        $data = $coursRepository->findBySearchTerm($searchTerm, $limit, $offset);
        $totalItems = $coursRepository->countBySearchTerm($searchTerm);

        $totalPages = ceil($totalItems / $limit);

         
 
        return $this->render('home/cours/filter/index.html.twig', [
            'data' => $data,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'limit' => $limit,
            'searchTerm' => $searchTerm,
        ]);
    }
}
