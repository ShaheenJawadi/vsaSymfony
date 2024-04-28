<?php
namespace App\Controller\Avis;

use App\Entity\User;
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
    private $security;

    public function index(): Response
    {
        return $this->render('home/reclamation/index.html.twig');
    }

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function ajouterRec(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userId = 3;
    
        // Obtenez l'entité User correspondant à l'ID statique
        $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
    
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé pour l\'ID '.$userId);
        }
    
        // Récupérer les données de la requête
        $type = $request->request->get('type');
        $description = $request->request->get('description');
        $status = "pending";
    
        // Valider le type
        $allowedTypes = ['cours', 'note', 'certificat', 'autre'];
        if (!in_array($type, $allowedTypes)) {
            throw new \InvalidArgumentException('Le type doit être l\'un des suivants : cours, note, certificat, autre.');
        }
    
        // Créer une nouvelle instance de l'entité Reclamation
        $reclamation = new Reclamations();
        $reclamation->setType($type);
        $reclamation->setDescription($description);
        $reclamation->setStatus($status);
        $reclamation->setIdUser($user);
        $reclamation->setDate(new \DateTime());
    
        // Persister et flusher l'entité Reclamation
        $entityManager->persist($reclamation);
        $entityManager->flush();
    
        // Rediriger vers la page de réclamation
        return $this->redirectToRoute('home_avis_afficher_reclamation');
    }
    public function afficherRec(ReclamationRepository $repo): Response
    {      
          // Récupérer toutes les réclamations depuis le repository
        $reclamations = $repo->findAll();

        // Transmettre les réclamations au template Twig pour l'affichage
        return $this->render('home/reclamation/afficher.html.twig', [
            'reclamations' => $reclamations,
        ]);
        
    }

}
