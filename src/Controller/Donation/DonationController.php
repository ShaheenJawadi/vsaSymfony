<?php

namespace App\Controller\Donation;

use App\Entity\CallAction;
use App\Entity\Donors;
use App\Repository\CallToActionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\UserSessionManager;

class DonationController extends AbstractController
{

    private $user_session ; 
    public function __construct(UserSessionManager $user_session)
    {
        $this->user_session = $user_session; 
    }


    public function index(Request $request, CallToActionRepository $callToActionRepository): Response
    {

        $actions_list = $callToActionRepository->findAll();
        $content = $this->renderView('home/components/callToAction/list.html.twig', [
            'actions_list' => $actions_list
        ]);

        return new Response($content);
    }

    public function processPayment(Request $request, ManagerRegistry $manager ,CallToActionRepository $callToActionRepository , UserRepository $userRepository): Response
    {
        Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        $amountInCents = $request->request->get('amount');
        $actionId = $request->request->get('action_id');
        $token = $request->request->get('stripeToken');
 
        Charge::create([
            'amount' => $amountInCents,
            'currency' => 'usd',
            'description' => 'Mug purchase',
            'source' => $token,
        ]);

        $em = $manager->getManager();
        $action = $callToActionRepository->find($actionId);
        $action->setGiven($action->getGiven() + $amountInCents);
        $em->persist($action);

        $donor = new Donors();
        $c_user = $this->user_session->getCurrentUser();
        $user = $userRepository->find($c_user->getId());

        $donor->setUserid($user);
        $donor->setMontant($amountInCents);

 

        $em->persist($donor);
        $em->flush();

        return $this->redirectToRoute('home_index');
    }
}
