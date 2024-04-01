<?php

namespace App\Controller\Admin;

 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request;
 

  
class ClassificationController extends AbstractController  
{
 

    public function category(): Response
    {
        return $this->render('admin/classification/category/index.html.twig');
    }

 
 
 
 
}
