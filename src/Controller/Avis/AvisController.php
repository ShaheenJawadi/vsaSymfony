<?php

namespace App\Controller\Avis;

use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Avis;
use App\Entity\User;
use App\Entity\Cours;
use App\Repository\AvisRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\AvisType;

class AvisController extends AbstractController
{
    public function index(AvisRepository $repo): Response
    {
        $avis = $repo->getAll(); // Récupérer la liste des avis depuis le repository
        $averageNote = $repo->getAverageNote(); // Récupérer la moyenne des notes
        $countByNote = [
            5 => $repo->getCountByNote(5),
            4 => $repo->getCountByNote(4),
            3 => $repo->getCountByNote(3),
            2 => $repo->getCountByNote(2),
            1 => $repo->getCountByNote(1),
        ]; // Récupérer le nombre d'avis pour chaque note
    
        return $this->render('home/avis/coursAvisSection.html.twig', [
            'avis' => $avis, // Transmettre la variable "avis" au fichier Twig
            'averageNote' => $averageNote, // Transmettre la moyenne des notes au fichier Twig
            'countByNote' => $countByNote, // Transmettre le nombre d'avis pour chaque note au fichier Twig
        ]);
    }
    

    public function ajouter(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $coursId = $request->request->get('courId');
        $note = $request->request->get('note');
        $message = $request->request->get('message');

        // ID utilisateur statique
        $userId = 3;

     

        // Obtenez l'entité User correspondant à l'ID statique
        $user = $this->getDoctrine()->getRepository(User::class)->find($userId);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé pour l\'ID '.$userId);
        }

        // Obtenez l'entité Cours correspondant à l'ID statique
        $cours = $this->getDoctrine()->getRepository(Cours::class)->find($coursId);

        if (!$cours) {
            throw $this->createNotFoundException('Cours non trouvé pour l\'ID '.$coursId);
        }

        // Créer une nouvelle instance de l'entité Avis
        $avis = new Avis();
        $avis->setNote($note);
        $avis->setMessage($message);
        
        // Associer l'utilisateur à l'avis
        $avis->setIdUser($user);

        // Associer le cours à l'avis
        $avis->setCoursid($cours);

        // Ajouter la date actuelle
        $date = new \DateTime();
        $avis->setDate($date);

        $entityManager->persist($avis);
        $entityManager->flush();



        $coursSlug= $request->request->get('courSlug');
        return $this->redirectToRoute('home_cours_page_index' ,["slug"=>$coursSlug]);
         
    }

  public function modifier( $id, $courSlug ,Request $req, AvisRepository $repo, ManagerRegistry $manger): Response
  {
      $em =$manger->getManager(); 

      $avis= $repo->find($id);

      $form=$this ->createForm(AvisType::class ,$avis);
      $form ->handleRequest($req);

      if ($form->isSubmitted()){
          $em->persist($avis);
          $em->flush();
          return $this->redirectToRoute('home_cours_page_index' ,["slug"=>$courSlug]);
      }
      
      return $this->renderForm('home/avis/modifier.html.twig', [
          'f'=>$form,
        "courSlug"=>$courSlug,
          'avis' => $avis,
      ]);
    
  }
  public function supprimer( $id, $courSlug ,ManagerRegistry $manger ,AvisRepository $repo): Response
  {
      $avis= $repo->find($id);
      $em =$manger->getManager(); 

      $em->remove($avis);
      $em->flush();
      return $this->redirectToRoute('home_cours_page_index',["slug"=>$courSlug]);
  }

  

  
}
