<?php

namespace App\Controller\Admin;

use App\Entity\Publications;
use App\Repository\PublicationsRepository;
use App\Repository\ReactionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;

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
        $chartData = $this->generateChartDataPublicationTime($pubs);
        $chartDataReactions=$this->generateChartDataReactions($reactionsByPubId,$pubs);
        return $this->render('admin/forum/index.html.twig', [
            'pubs' => $pubs,
            'reactionsByPubId' => $reactionsByPubId,
            'chartData' => $chartData,
            'reactionChartData' => json_encode($chartDataReactions),

        ]);
        
    }
    private function generateChartDataReactions(array $reactionsByPubId, array $pubs) {
        $chartData = [];

        foreach ($pubs as $pub) {
            $pubId = $pub->getId();
            if(isset($reactionsByPubId[$pubId])) {
                if($reactionsByPubId[$pubId]['jaime'] > 0 || $reactionsByPubId[$pubId]['dislike'] > 0){
                    $singlePubData = [
                        ['Reaction', 'Count'],
                        ['Likes', $reactionsByPubId[$pubId]['jaime'] ?? 0],
                        ['Dislikes', $reactionsByPubId[$pubId]['dislike'] ?? 0],
                    ];
                    $chartData[$pub->getTitre()] = $singlePubData;
                }
            }
        }
    
        return $chartData;
    }
    private function generateChartDataPublicationTime($pubs)
    {
        $publicationDates = [];
        $today = new \DateTime('now');
    
        foreach ($pubs as $pub) {
            $publicationDate = $pub->getDateCreation();
    
            if ($publicationDate->format('Y-m-d') <= $today->format('Y-m-d')) {
                $dateKey = $publicationDate->format('Y-m-d');
    
                if (!array_key_exists($dateKey, $publicationDates)) {
                    $publicationDates[$dateKey] = 0;
                }
    
                $publicationDates[$dateKey]++;
            }
        }
    
        // Create chart data array
        $chartData = [['Date', 'Number of Publications']];
    
        foreach ($publicationDates as $date => $count) {
            $chartData[] = [$date, $count];
        }
    
        return $chartData;
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
