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
    
  
    public function single($id, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = $reclamationRepository->find($id);

        if (!$reclamation) {
            throw $this->createNotFoundException('Réclamation non trouvée');
        }

        return $this->render('admin/reclamation/single.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }  
    public function delete_Rec($id, ReclamationRepository $Rep, ManagerRegistry $manger): Response
    {
        $Rec= $Rep->find($id);
        
        $em =$manger->getManager(); 

        $em->remove($Rec);
        $em->flush();
    
        return $this->redirectToRoute('admin_reclamations');
    }
    public function detailsReclamation($id,Reclamations $reclamation): Response
    {
        return $this->render('admin/reclamation/single.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }
    public function modifierStatut(Request $request, $id, ReclamationRepository $reclamationRepository): Response
    {
        // Trouver la réclamation à partir de son identifiant
        $reclamation = $reclamationRepository->find($id);

        if (!$reclamation) {
            throw $this->createNotFoundException('Réclamation non trouvée');
        }

        $nouveauStatut = $request->request->get('nouveau_statut');

        // Vérifier si le nouveau statut est valide (à ajouter selon vos besoins)
        // Exemple de validation basique :
        if (!in_array($nouveauStatut, ['en_attente', 'en_cours', 'reponse_envoyee_par_email'])) {
            throw $this->createNotFoundException('Statut invalide');
        }

        // Mettre à jour le statut de la réclamation
        $reclamation->setStatus($nouveauStatut);
        
        // Enregistrer les modifications dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        // Redirection vers la page de détails de la réclamation
        return $this->redirectToRoute('admin_reclamations', ['id' => $reclamation->getIdReclamation()]);
    }
}  
    
  
