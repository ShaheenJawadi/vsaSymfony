<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use App\Service\UserSessionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $user_session ; 
    public function __construct(UserSessionManager $user_session)
    {
        $this->user_session = $user_session; 
    }

    public function index(CoursRepository $coursRepository): Response
    {

        $lastThreeCourses = $coursRepository->findLastThreeCourses();
        $user = $this->user_session->getCurrentUser();

        return $this->render('home/main/index.html.twig', [
            'lastThreeCourses' => $lastThreeCourses,
            'current_user'=>$user 
        ]);
    }
}
