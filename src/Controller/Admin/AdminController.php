<?php

namespace App\Controller\Admin;

 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request;
 

  
class AdminController extends AbstractController  
{
 

    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig');
    }

 
 
 
 
}
