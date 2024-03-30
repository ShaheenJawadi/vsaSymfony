<?php

namespace App\Controller\Teacher;

use App\Entity\Cours;
use App\Entity\Lessons;
use App\Entity\Level;
use App\Entity\Ressources;
use App\Entity\Souscategorie;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;


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

    public function add_lesson(): Response
    {
        $content = $this->renderView('teacher/components/cours/single_lesson_form.html.twig');

        return new Response($content);
    }


    public function create(Request $request,  ValidatorInterface $validator): Response
    {

        $formData = $request->request->all();

        $lessonItems = $request->request->get('lesson_list', []);

      

        $coursEntity = $this->collectCoursData($formData);
        $ressourceEntity = $this->collectRessourceData($formData);
        $lessonsEntityList =$this->collectLessonsData($request);


        $errors = $this->validation($coursEntity, $ressourceEntity ,$lessonsEntityList, $validator);

        if (count($errors) > 0) {


            return $this->json(['success' => false, 'errors' => $errors, 'formData' => $formData], Response::HTTP_BAD_REQUEST);
        }


        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($coursEntity);
        $ressourceEntity->setCoursid($coursEntity);
        $entityManager->persist($ressourceEntity);
        foreach ($lessonsEntityList as $lessonItem) { 
            $lessonItem->setCoursid($coursEntity);
            $entityManager->persist($lessonItem);

        }
        $entityManager->flush();


        return $this->json(['success' => true, 'message' => 'success'], Response::HTTP_OK);
    }



    public function collectCoursData($formData): Cours
    {

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


        $slugger = new AsciiSlugger();
        $entity->setSlug($slugger->slug($formData['nom'])->lower());


        return $entity;
    }

    public function collectRessourceData($formData): Ressources
    {



        $entity = new Ressources();
        $entity->setLien($formData['ressource_link']);
        $entity->setType($formData['ressource_type']);




        return $entity;
    }


    private function validation($coursEntity, $ressourceErrors,$lessonsEntityList, ValidatorInterface $validator)
    {


        $coursErrors = $validator->validate($coursEntity);


        $formErrors = [];
        if (count($coursErrors) > 0) {

            foreach ($coursErrors as $error) {
                $propertyPath = $error->getPropertyPath();
                $message = $error->getMessage();
                $formErrors[$propertyPath] = $message;
            }
        }


        $ressourceErrors = $validator->validate($ressourceErrors);
        if (count($ressourceErrors) > 0) {

            foreach ($ressourceErrors as $error) {
                $propertyPath = $error->getPropertyPath();
                $message = $error->getMessage();
                $formErrors[$propertyPath] = $message;
            }
        }



        foreach ($lessonsEntityList as $lessonItem) { 
            $lessonErrors = $validator->validate($lessonItem);

            if (count($lessonErrors) > 0) {

                foreach ($ressourceErrors as $error) {
                    $propertyPath = $error->getPropertyPath();
                    $message = $error->getMessage();
                    $formErrors[$propertyPath] = $message;
                }
            }
 
        }

        return $formErrors;
    }



    public function collectLessonsData($request): array  
    {

     
        $lessons = [];
        $lessonCount = count($request->request->get('lesson_title', []));
        for ($i = 0; $i < $lessonCount; $i++) {
            $entity = new Lessons();
            $entity->setTitre($request->request->get('lesson_title')[$i]);
            $entity->setVideo($request->request->get('lesson_video')[$i]);
            $entity->setContent($request->request->get('lesson_content')[$i]);
            $entity->setDuree($request->request->get('lesson_duration')[$i]);
            $entity->setClassement($request->request->get('lesson_order')[$i]);

            $lessons[] = $entity;
        }


        



        return $lessons;
    }

    

}
