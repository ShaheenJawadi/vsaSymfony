<?php

namespace App\Controller\Teacher;

 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request;
 

  
class TeacherController extends AbstractController  
{
 

    public function index(): Response
    {
        return $this->render('teacher/dashboard/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

 

    public function students_page(Request $request ): Response
    {
 
   
 

        return $this->render('teacher/students/index.html.twig' ); 


 
    }
    public function datatableData(Request $request )
    {

    

         
    }
 
 
}
