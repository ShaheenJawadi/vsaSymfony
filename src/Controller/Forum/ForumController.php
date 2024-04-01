<?php

namespace App\Controller\Forum;

use App\Entity\Commentaires;
use App\Entity\Publications;
use App\Entity\Reactions;
use App\Entity\User;
use App\Form\CommentairesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\PublicationsType;
use App\Repository\PublicationsRepository;
use App\Repository\ReactionsRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface; 

use App\Repository\CommentairesRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



use App\Repository\UserRepository;
use App\Service\OpenAIService;

class ForumController extends AbstractController
{

    public function index(Request $request, ReactionsRepository $reactionsRepository, ManagerRegistry $manager, UserRepository $userRepository, PublicationsRepository $rep,OpenAIService $openAIService, CommentairesRepository $commentairesRepository): Response
    {
        
        $formResponse = $this->addPublication($request, $manager,$openAIService, $userRepository,$rep);
        if ($formResponse !== null) {
            return $formResponse; 
        }
        $publications = $this->getAllPublications($rep);
        $user = $userRepository->find(18); // FIXME: userid=18
        $contributors = $this->getContributors($rep);
        foreach ($publications as $pub) {
            $commentForm = $this->createForm(CommentairesType::class, new Commentaires(), [
                'action' => $this->generateUrl('home_forum_add_comment', ['idPub' => $pub->getId()]), // Adjust 'your_route_to_handle_comment' and 'idPub' as necessary
            ]);
            $commentForms[$pub->getId()] = $commentForm->createView();
            $commentForm->get('returnPath')->setData('index');

        }
        $filter = $request->query->get('filter');

        switch ($filter) {
            case 'myPublications':
                $publications = $rep->findPubByUserId($user->getId());
                break;
            case 'populaire':
                $publications = array_filter($rep->findAllPublicationsOrderedByClicks(), function($pub) {
                    return $pub->getNbClicks() !== null; // Assuming getNbClicks() is your getter method for nbClicks
                });
                break;
            case'mostLiked':
                $publications=$rep->findAllPublicationsOrderedByJaime();
                break;
            case'mostDisliked':
                $publications=$rep->findAllPublicationsOrderedByDislike();
                break;
            default:
                $publications = $this->getAllPublications($rep);
                break;
        }
        $reactionsSummary = $reactionsRepository->findReactionsSummary();
        $reactionsByPubId = [];
        foreach ($reactionsSummary as $reaction) {
            $reactionsByPubId[$reaction['pubId']] = [
                'jaime' => $reaction['totalJaime'],
                'dislike' => $reaction['totalDislike']
            ];
        }
        $userReactions = $reactionsRepository->findBy(['user' => $user]);
        $userReactionsMap = [];
        foreach ($userReactions as $reaction) {
            if ($reaction->getJaime() === 1) {
                $userReactionsMap[$reaction->getPub()->getId()] = 'like';
            } elseif ($reaction->getDislike() === 1) {
                $userReactionsMap[$reaction->getPub()->getId()] = 'dislike';
            }
        }
        foreach ($publications as $pub) {
            $pubId = $pub->getId();
            $pub->userReaction = $userReactionsMap[$pubId] ?? null;
        }
        
        return $this->render('home/forum/index.html.twig', [
            'controller_name' => 'ForumController',
            'forumPub' => $this->createForm(PublicationsType::class, new Publications())->createView(), 
            'pubs' => $publications,
            'user' => $user,
            'contributors' => $contributors,
            'commentForms' => $commentForms,
            'reactionsByPubId' => $reactionsByPubId,
            'userReactionsMap' => $userReactionsMap, // Add this line


        ]);
    }
   
    //----------------------------------------------------------------------------------//
    public function getAllPublications(PublicationsRepository $rep)
    {

       return $rep->findAllPublicationsWithUserDetails();
       
    }

    //----------------------------------------------------------------------------------//

    public function addPublication(Request $request, ManagerRegistry $manager,OpenAIService $openAIService, UserRepository $userRepository,$publicationsRepository): ?Response
    {
        $form = $this->createForm(PublicationsType::class, new Publications());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $manager->getManager();
            $publication = $form->getData();
            $publication->setDateCreation(new \DateTime());
            //FIXME:USER18 

            $user18 = $userRepository->find(18);
            if (!$user18) {
                throw $this->createNotFoundException('No user found for ID 18');
            }

            $publication->setUser($user18);
            $existingPublication = $publicationsRepository->findExistingPublication(
                $user18->getId(),
                $publication->getTitre(),
                $publication->getContenu()
            );
            
            if ($existingPublication) {
                $this->addFlash('danger', 'A publication with the same title and content already exists.');
                return $this->redirectToRoute('home_forum_index'); // Adjust the route name accordingly
            }
            $publicationText = $publication->getTitre() . " - " . $publication->getContenu();
            if ($openAIService->checkContent($publicationText)) {
                $this->addFlash('danger', 'Your publication contains inappropriate content and cannot be added.');
                return $this->redirectToRoute('home_forum_index');
            }
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
  public function deleteComment(ManagerRegistry $manager, $idC, CommentairesRepository $rep, Request $request)
    {
        $comment = $rep->find($idC);
        $em = $manager->getManager();
        $em->remove($comment);
        $em->flush();
        
        // Check for the publication ID in the query parameters
        $idPub = $request->query->get('idPub');

        // Redirect based on the presence of the publication ID
        if ($idPub !== null) {
            return $this->redirectToRoute('home_forum_single_publication', ['idPub' => $idPub]);
        } else {
            return $this->redirectToRoute('home_forum_index');
        }
    }
//----------------------------------------------------------------------------------//
public function updateComment(Request $request, EntityManagerInterface $entityManager, CommentairesRepository $commentairesRepository): Response
{
    $commentId = $request->request->get('commentId');
    $newContent = $request->request->get('comment');

    $comment = $commentairesRepository->find($commentId);
    if (!$comment) {
        return new JsonResponse(['error' => 'Comment not found'], 404);
    }

    $comment->setCommentaire($newContent);
    $entityManager->flush();

    return new JsonResponse(['success' => 'Comment updated']);
}

public function addComment(Request $request, ManagerRegistry $manager, UserRepository $userRepository, PublicationsRepository $pubRep, $idPub,OpenAIService $openAIService): ?Response
{
    $form = $this->createForm(CommentairesType::class, new Commentaires());
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $manager->getManager();
        $comment = $form->getData();
        $comment->setDate(new \DateTime());

        $publication = $pubRep->find($idPub);
        if (!$publication) {
            throw $this->createNotFoundException(sprintf('No publication found for ID %d', $idPub));
        }
        $comment->setIdPub($publication); 

        $user = $userRepository->find(18);
        if (!$user) {
            throw $this->createNotFoundException('No user found for ID 18');
        }
        $comment->setUser($user);
        $commentText = $comment->getCommentaire();
        if ($openAIService->checkContent($commentText)) {
            $this->addFlash('danger', 'Your comment contains inappropriate content and cannot be added.');
            return $this->redirectToRoute('home_forum_index');
        }
        $em->persist($comment);
        $em->flush();

        $this->addFlash('success', 'Comment added successfully.');

        $returnPath = $form->get('returnPath')->getData(); 

        if ($returnPath === 'index') {
            // If the comment was added from the index page, redirect back there
            return $this->redirectToRoute('home_forum_index');
        } else {
            // Otherwise, redirect to the single publication page
            return $this->redirectToRoute('home_forum_single_publication', ['idPub' => $idPub]);
        }
    }

   
    return null; 
}







public function single(PublicationsRepository $rep, ReactionsRepository $reactionsRepository,OpenAIService $openAIService, int $idPub, Request $request, ManagerRegistry $manager, UserRepository $userRepository): Response
{
    // Attempt to handle adding a comment if the form is submitted
    $formResponse = $this->addComment($request, $manager, $userRepository, $rep, $idPub,$openAIService);
    if ($formResponse !== null) {
        return $formResponse;
    }

    // Create the comment form
    $commentForm = $this->createForm(CommentairesType::class, new Commentaires());

    // Set the returnPath dynamically based on the current action
    $commentForm->get('returnPath')->setData('single'); // Use a clear and consistent identifier for the return path

    $publication = $rep->findPublicationWithUserDetails($idPub);
    $contributors = $this->getContributors($rep);

    $reactionsSummary = $reactionsRepository->findReactionsSummary();
    $reactionsByPubId = [];
    foreach ($reactionsSummary as $reaction) {
        $reactionsByPubId[$reaction['pubId']] = [
            'jaime' => $reaction['totalJaime'],
            'dislike' => $reaction['totalDislike']
        ];
    }    
    return $this->render('home/forum/single.html.twig', [
        'controller_name' => 'ForumController',
        'pub' => $publication,
        'contributors' => $contributors,
        'commentForm' => $commentForm->createView(),
        'reactionsByPubId' => $reactionsByPubId,

    ]);
}

public function updatePublication(Request $request, EntityManagerInterface $em, PublicationsRepository $rep, $idPub): Response
{
    if ($request->isXmlHttpRequest()) {
        $data = json_decode($request->getContent(), true);

        $publication = $rep->find($idPub);
        if ($publication) {
            $publication->setTitre($data['titre']);
            $publication->setContenu($data['contenu']);

            $em->persist($publication);
            $em->flush();

            return new JsonResponse(['status' => 'success', 'message' => 'Publication updated successfully']);
        }

        return new JsonResponse(['status' => 'error', 'message' => 'Publication not found']);
    }

}

public function edit(Request $request,ManagerRegistry $manager, PublicationsRepository $rep, int $idPub): Response
{
    $publication = $rep->findPublicationWithUserDetails($idPub);
    $em= $manager->getManager();
    $form=$this->createForm(PublicationsType::class,$publication);
    $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em->flush();
            return $this->redirectToRoute('home_forum_index');
        }
        $content = $this->renderView('home/components/forum/editForum_popup.html.twig', ['pub' => $publication,'formUp'=>$form]);


        return new Response($content);
    
}

public function reactToPublication($pubId, $reactionType, ReactionsRepository $reactionsRepository, ManagerRegistry $manager, PublicationsRepository $publicationsRepository, UserRepository $userRepository): Response
{
    $entityManager = $manager->getManager();
    $user = $userRepository->find(18); // Assuming this is just for testing and will be dynamic in the application
    $publication = $publicationsRepository->find($pubId);

    if (!$publication || !$user) {
        return $this->redirectToRoute('home_forum_index');
    }

    $reaction = $reactionsRepository->findOneBy(['pub' => $publication, 'user' => $user]);

    if ($reaction) {
        // Reaction exists, so we toggle the like/dislike or remove it if the same reaction is clicked again
        if (($reactionType === 'like' && $reaction->getJaime() === 1) || ($reactionType === 'dislike' && $reaction->getDislike() === 1)) {
            // User clicked the same reaction again, so we "unreact" by removing the reaction record
            $entityManager->remove($reaction);
        } else {
            // Toggle the reaction
            if ($reactionType === 'like') {
                $reaction->setJaime(1);
                $reaction->setDislike(0);
            } else {
                $reaction->setJaime(0);
                $reaction->setDislike(1);
            }
            $entityManager->persist($reaction);
        }
    } else {
        // No existing reaction, create a new one
        $reaction = new Reactions();
        $reaction->setPub($publication);
        $reaction->setUser($user);
        if ($reactionType === 'like') {
            $reaction->setJaime(1);
            $reaction->setDislike(0);
        } else {
            $reaction->setJaime(0);
            $reaction->setDislike(1);
        }
        $entityManager->persist($reaction);
    }

    $entityManager->flush();

    return $this->redirectToRoute('home_forum_index');
}

    //---------------------------------------------------------------------------------//
    public function chatBotIndex(Request $request, UserRepository $userRepository): Response
    {
        $user = $userRepository->find(3);
    
        $userImage = null;
        if ($user && $user->getImage()) {
            $userImage = $user->getImage(); 
        }
    
        return $this->render('home/forum/chatbot.html.twig', [
            'userImage' => $userImage,
        ]);
    }
    
 
    
   
  public function chatBotAction(Request $request, OpenAIService $openAIService, SessionInterface $session): JsonResponse {
    if ($request->isXmlHttpRequest()) {
        $data = json_decode($request->getContent(), true);
        $userMessage = $data['message'] ?? '';

        $history = $session->get('chat_history', []);

        $responseMessage = $openAIService->getChatResponse($userMessage, $history);

        // Update the conversation history
        // Note: You may need to adjust the structure depending on how you want to display messages
        $history[] = ['role' => 'user', 'content' => $userMessage];
        $history[] = ['role' => 'assistant', 'content' => $responseMessage]; // Assuming the role is 'assistant'
        $session->set('chat_history', $history);

        return new JsonResponse(['message' => $responseMessage]);
    }

    return new JsonResponse(['error' => 'Invalid request type'], Response::HTTP_BAD_REQUEST);
}




}