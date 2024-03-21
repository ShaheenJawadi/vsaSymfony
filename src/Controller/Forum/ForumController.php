<?php

namespace App\Controller\Forum;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('home/forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }



    public function chatBotIndex(): Response
    {
        return $this->render('home/forum/chatbot.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }

   
}
