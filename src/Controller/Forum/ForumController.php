<?php

namespace App\Controller\Forum;

use App\Entity\Publications;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\PublicationsType;
use App\Repository\PublicationsRepository;
use App\Repository\CommentairesRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;


use App\Repository\UserRepository;
class ForumController extends AbstractController
{

    public function index(Request $request, ManagerRegistry $manager, UserRepository $userRepository,PublicationsRepository $rep, CommentairesRepository $commentairesRepository): Response
    {
        $form=$this->addPublication( $request, $manager, $userRepository);

        $publication=$this->getAllPublications($rep);

        //FIXME: userid=18
        $user = $userRepository->find(18);
        $contributors=$this->getContributors($rep);
        
        return $this->render('home/forum/index.html.twig', [
            'controller_name' => 'ForumController',
            'forumPub'=>$form->createView(),
            'pubs'=>$publication,
            'user'=>$user,
            'contributors'=>$contributors
        ]);
    }
   
    //----------------------------------------------------------------------------------//
    public function getAllPublications(PublicationsRepository $rep)
    {

       return $rep->findAllPublicationsWithUserDetails();
       
    }

    //----------------------------------------------------------------------------------//

    public function addPublication(Request $request, ManagerRegistry $manager, UserRepository $userRepository)
    {
        $em= $manager->getManager();
        $publication = new Publications();
        $form = $this->createForm(PublicationsType::class, $publication);

        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
           // if($form->isValid()){
            $publication->setDateCreation(new \DateTime());
            
             //FIXME: userid=18

            $user18 = $userRepository->find(18);
            if (!$user18) {
                throw $this->createNotFoundException('No user found for ID 18');
            }
            $publication->setUser($user18);
            $em->persist($publication);
            $em->flush();
            //TODO:refresh!!
            // return $this->redirectToRoute('/forum');
        
        // else {
        //     $errors = $form->getErrors(true);
        //     foreach ($errors as $error) {
        //         if ($error->getMessage() === "A publication with this title and content already exists.") {
        //             $form->addError(new FormError("This publication title and content combination is already in use."));
        //         }
        //     }
        // }
        } 
        return $form;
        }

 //----------------------------------------------------------------------------------//
 public function getContributors(PublicationsRepository $publicationsRepository)
 {
    return  $publicationsRepository->findDistinctContributors();
 
 }
 

  //----------------------------------------------------------------------------------//

      public function chatBotIndex(): Response
    {
        return $this->render('home/forum/chatbot.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }
   

   
}
