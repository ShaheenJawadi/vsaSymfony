<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{

    public function loadLoginPopup(): Response
    {

        $content = $this->renderView('home/auth/popup/login.html.twig');

        return new Response($content);
    }


    public function loadRegisterPopup(): Response
    {

        $content = $this->renderView('home/auth/popup/register.html.twig');

        return new Response($content);
    }

    public function loadResetPwsPopup(): Response
    {

        $content = $this->renderView('home/auth/popup/resetPws.html.twig');

        return new Response($content);
    }
}