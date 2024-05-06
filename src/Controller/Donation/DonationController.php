<?php

namespace App\Controller\Donation;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request;

class DonationController extends AbstractController
{
    
    public function index(Request $request ): Response
    {
       
        $content = $this->renderView('home/components/callToAction/list.html.twig');

        return new Response($content);
 
        
    }

  
    

}
