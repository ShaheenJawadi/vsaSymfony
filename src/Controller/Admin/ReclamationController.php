<?php

namespace App\Controller\Admin;

use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
 

class ReclamationController extends AbstractController
{
 
    public function index(): Response
    {
        return $this->render('home/reclamation/index.html.twig');
    }
  

  
}
