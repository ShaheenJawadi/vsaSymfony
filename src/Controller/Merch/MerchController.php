<?php

namespace App\Controller\Merch;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MerchController extends AbstractController
{
    
    public function index(Request $request): Response
    {
    
 
        return $this->render('home/merch/filter/index.html.twig', [
            
        ]);
    }

    public function productPage(Request $request): Response
    {
    
 
        return $this->render('home/merch/single/index.html.twig', [
            
        ]);
    }
    

}
