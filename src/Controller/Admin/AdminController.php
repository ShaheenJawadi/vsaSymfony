<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class AdminController extends AbstractController
{


    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig');
    }


    public function users(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render(
            'admin/users/index.html.twig',
            ['users' => $users]
        );
    }
}
