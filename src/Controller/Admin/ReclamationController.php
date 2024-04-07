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
        return $this->render('admin/reclamation/index.html.twig');
    }
  
    public function single($id): Response
    {
        return $this->render('admin/reclamation/single.html.twig');
    }
  
}
