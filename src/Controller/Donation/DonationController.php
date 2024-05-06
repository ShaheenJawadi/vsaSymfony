<?php

namespace App\Controller\Donation;

use App\Repository\CallToActionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request;

class DonationController extends AbstractController
{
    
    public function index(Request $request , CallToActionRepository $callToActionRepository): Response
    {
       
        $actions_list = $callToActionRepository->findAll();
        $content = $this->renderView('home/components/callToAction/list.html.twig' ,[
            'actions_list'=>$actions_list
        ]);

        return new Response($content);
 
        
    }

  
    

}
