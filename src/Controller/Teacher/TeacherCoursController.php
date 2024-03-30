<?php

namespace App\Controller\Teacher;

use App\Entity\Cours;
use App\Entity\Level;
use App\Entity\Ressources;
use App\Entity\Souscategorie;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class TeacherCoursController extends AbstractController
{


    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function index(): Response
    {
        return $this->render('teacher/cours/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

  

    public function add(): Response
    {
        return $this->render('teacher/cours/add/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

    public function add_lesson( ): Response
    {
        $content = $this->renderView('teacher/components/cours/single_lesson_form.html.twig');

        return new Response($content);
      
    }


    public function create(Request $request, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {
        
        $formData = $request->request->all(); 
        
        $entity =$this->collectCoursData($formData);
       
        $errors = $validator->validate($entity);
 
        if (count($errors) > 0) {
            $formErrors = [];
            foreach ($errors as $error) {
                $propertyPath = $error->getPropertyPath();
                $message = $error->getMessage();
                $formErrors[$propertyPath] = $message;
            }

            return $this->json(['success' => false, 'errors' => $formErrors, 'formData' => $formData], Response::HTTP_BAD_REQUEST);
        }

         
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();

        
        return $this->json(['success' => true, 'message' => 'success'], Response::HTTP_OK);
    }



    public function collectCoursData($formData  ):Cours{

        $user = $this->managerRegistry->getRepository(User::class)->find(3);
        $sousCategory = $this->managerRegistry->getRepository(Souscategorie::class)->find($formData['subCategoryId']);

        $level = $this->managerRegistry->getRepository(Level::class)->find($formData['niveauId']);


        $entity = new Cours(); 
        $entity->setEnseignantid($user); 
        $entity->setNom($formData['nom']); 

        $entity->setImage($formData['image']); 
        $entity->setDescription($formData['description']); 
        $entity->setTags($formData['tags']); 
        $entity->setSubcategoryid($sousCategory); 
        $entity->setNiveauid($level); 

        $entity->setSlug($formData['nom']); 


        return $entity;
    }

    
}
