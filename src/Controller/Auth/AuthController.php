<?php

namespace App\Controller\Auth;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use App\Form\UserModifyType;
use App\Repository\UserRepository;

class AuthController extends AbstractController
{

    public function loadLoginPopup(): Response
    {

        $content = $this->renderView('home/auth/popup/login.html.twig');

        return new Response($content);
    }



    public function loadRegisterPopup(Request $request, ManagerRegistry $manager): Response
    { 
        $content = $this->renderView(
            'home/auth/popup/register.html.twig' 
        );
        return new Response($content);
    }



    public function loadResetPwsPopup(): Response
    {

        $content = $this->renderView('home/auth/popup/resetPws.html.twig');
        return new Response($content);
    }

    public function register(Request $request ,ManagerRegistry $managerRegistry) {

        $formData = $request->request->all();
        

        $userEntity = new User();
        $userEntity->setNom($formData["nom"]);
        $userEntity->setPrenom($formData["prenom"]);

        $userEntity->setUsername($formData["username"]);
        $userEntity->setEmail($formData["email"]);
        $userEntity->setPassword($formData["password"]);

        // $formData["repreta_password"]
    

        $entityManager = $managerRegistry->getManager();
        $entityManager->persist($userEntity);
        
         
        
        $entityManager->flush();
        return $this->redirectToRoute('home_index');
        

    }
 

    
}
