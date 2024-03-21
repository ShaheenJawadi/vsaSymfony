<?php

namespace App\Controller\Cours;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilterController extends AbstractController
{
    
    public function index(): Response
    {
        return $this->render('cours/filter/index.html.twig', [
            'controller_name' => 'FilterController',
        ]);
    }
}
