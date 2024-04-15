<?php

namespace App\Controller\Admin;

use App\Entity\Publications;
use App\Repository\PublicationsRepository;
use App\Repository\ReactionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;


class ForumController extends AbstractController
{
 
    public function index(PublicationsRepository $repo,ReactionsRepository $reactionsRepository): Response
    {      
        $pubs = $repo->findAllPublicationsWithUserDetails();
        $reactionsSummary = $reactionsRepository->findReactionsSummary();
        $reactionsByPubId = [];
        foreach ($reactionsSummary as $reaction) {
            $reactionsByPubId[$reaction['pubId']] = [
                'jaime' => $reaction['totalJaime'],
                'dislike' => $reaction['totalDislike']
            ];
        }
        return $this->render('admin/forum/index.html.twig', [
            'pubs' => $pubs,
            'reactionsByPubId' => $reactionsByPubId,

        ]);
        
    }
    
  
    public function single($id,PublicationsRepository $repo,ReactionsRepository $reactionsRepository): Response
    {
        $pub = $repo->findPublicationWithUserDetails($id);
        $reactionsSummary = $reactionsRepository->findReactionsSummary();
        $reactionsByPubId = [];        
        foreach ($reactionsSummary as $reaction) {
            $reactionsByPubId[$reaction['pubId']] = [
                'jaime' => $reaction['totalJaime'],
                'dislike' => $reaction['totalDislike']
            ];
        }    
        return $this->render('admin/forum/single.html.twig', [
            'pub' => $pub,
            'reactionsByPubId' => $reactionsByPubId,

        ]);
    }  
  
    public function deletePublication(ManagerRegistry $manager,$id,PublicationsRepository $rep)
    {
         $PUB=$rep->find($id);
         $em=$manager->getManager();
         $em->remove($PUB);
         $em->flush();
        
        return $this->redirectToRoute('admin_forum_index');
    }
        
    
  
}
