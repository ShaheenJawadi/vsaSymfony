<?php

namespace App\Controller\Donation;

use App\Repository\CallToActionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request;
use Stripe\Stripe;
use Stripe\Charge;


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

    public function processPayment(Request $request): Response
    {
        Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        // Get payment token from the request
        $token = $request->request->get('stripeToken');

        // Create charge
        Charge::create([
            'amount' => 1000,
            'currency' => 'usd',
            'description' => 'Mug purchase',
            'source' => $token,
        ]);

        return $this->redirectToRoute('payment_success');
    }

  
    

}
