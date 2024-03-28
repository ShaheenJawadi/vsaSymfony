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

    public function index(Request $request, ManagerRegistry $manager, UserRepository $userRepository, PublicationsRepository $rep, CommentairesRepository $commentairesRepository): Response
    {


        $formResponse = $this->addPublication($request, $manager, $userRepository);
        if ($formResponse !== null) {
            return $formResponse; 
        }


        $publication = $this->getAllPublications($rep);
        $user = $userRepository->find(18); // FIXME: userid=18
        $contributors = $this->getContributors($rep);
        
        return $this->render('home/forum/index.html.twig', [
            'controller_name' => 'ForumController',
            'forumPub' => $this->createForm(PublicationsType::class, new Publications())->createView(), 
            'pubs' => $publication,
            'user' => $user,
            'contributors' => $contributors
        ]);
    }
   
    //----------------------------------------------------------------------------------//
    public function getAllPublications(PublicationsRepository $rep)
    {

       return $rep->findAllPublicationsWithUserDetails();
       
    }

    //----------------------------------------------------------------------------------//

    public function addPublication(Request $request, ManagerRegistry $manager, UserRepository $userRepository): ?Response
    {
        $form = $this->createForm(PublicationsType::class, new Publications());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $manager->getManager();
            $publication = $form->getData();
            $publication->setDateCreation(new \DateTime());

            $user18 = $userRepository->find(18);
            if (!$user18) {
                throw $this->createNotFoundException('No user found for ID 18');
            }
            $publication->setUser($user18);
            $em->persist($publication);
            $em->flush();

            $this->addFlash('success', 'Publication added successfully.');
            return $this->redirectToRoute('home_forum_index');
        }

        return null; 
    }


 //----------------------------------------------------------------------------------//
 public function getContributors(PublicationsRepository $publicationsRepository)
 {
    return  $publicationsRepository->findDistinctContributors();
 
 }
 

  //----------------------------------------------------------------------------------//
  public function deletePublication(ManagerRegistry $manager,$idPub,PublicationsRepository $rep)
  {
       $PUB=$rep->find($idPub);
       $em=$manager->getManager();
       $em->remove($PUB);
       $em->flush();
      
      return $this->redirectToRoute('home_forum_index');
  }
  //----------------------------------------------------------------------------------//
  public function deleteComment(ManagerRegistry $manager,$idC,CommentairesRepository $rep)
  {
       $comment=$rep->find($idC);
       $em=$manager->getManager();
       $em->remove($comment);
       $em->flush();
      
      return $this->redirectToRoute('home_forum_index');
  }








  public function single(PublicationsRepository $rep,int $idPub): Response
  {
 
    $publication = $this->getAllPublications($rep)[0];
      
      return $this->render('home/forum/single.html.twig', [
          'controller_name' => 'ForumController',
          'pub' => $publication,
          
      ]);
  }
  //----------------------------------------------------------------------------------//
      public function chatBotIndex(): Response
    {
        return $this->render('home/forum/chatbot.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }
   


    
   
}
