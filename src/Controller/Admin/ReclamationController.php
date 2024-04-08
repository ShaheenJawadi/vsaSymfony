<?php

namespace App\Controller\Admin;

use App\Entity\Reclamations;
use App\Repository\ReclamationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;


class ReclamationController extends AbstractController
{
 
    public function index(ReclamationRepository $repo): Response
    {      
          // Récupérer toutes les réclamations depuis le repository
        $reclamations = $repo->findAll();

        // Transmettre les réclamations au template Twig pour l'affichage
        return $this->render('admin/reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
        
    }
    
  
    public function single($id): Response
    {
        return $this->render('admin/reclamation/single.html.twig');
    }  
    public function delete_Rec($id, ReclamationRepository $Rep, ManagerRegistry $manger): Response
    {
        $Rec= $Rep->find($id);
        
        $em =$manger->getManager(); 

        $em->remove($Rec);
        $em->flush();
    
        return $this->redirectToRoute('admin_reclamations');
    }
        
    
  
}
