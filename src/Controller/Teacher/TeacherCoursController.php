<?php

namespace App\Controller\Teacher;

use App\Entity\Cours;
use App\Entity\Lessons;
use App\Entity\Level;
use App\Entity\Ressources;
use App\Entity\Souscategorie;
use App\Entity\User;
use App\Repository\CoursRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\UploadImg;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
 

class TeacherCoursController extends AbstractController
{


    private $managerRegistry; 
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
      
    }


 

    public function index(CoursRepository $coursRepository): Response
    {
        $list_cours = $coursRepository->findAll();
        return $this->render('teacher/cours/index.html.twig', [
            'my_cours' => $list_cours,
        ]);
    }



    public function add(): Response
    {
        return $this->render('teacher/cours/add/index.html.twig');
    }

    public function add_lesson(): Response
    {
        $content = $this->renderView('teacher/components/cours/single_lesson_form.html.twig');

        return new Response($content);
    }


    public function create(Request $request,  ValidatorInterface $validator, UploadImg $imageUploader): Response
    {



        $file = $request->files->get('image');  
        $tempFilePath = $file->getRealPath();
 
        $uploadResult = $imageUploader->upload($tempFilePath);
 
        $formData = $request->request->all();


        $updateCoursId = $request->request->get('coursId');
        $formData['image'] = $uploadResult;


        $coursEntity = $this->collectCoursData($formData);
        $ressourceEntity = $this->collectRessourceData($formData);
        $lessonsEntityList = $this->collectLessonsData($request);


        $errors = $this->validation($coursEntity, $ressourceEntity, $lessonsEntityList, $validator);

        if (count($errors) > 0) {


            return $this->json(['success' => false, 'errors' => $errors, 'formData' => $formData], Response::HTTP_BAD_REQUEST);
        }
        $entityManager = $this->managerRegistry->getManager();




        if ($updateCoursId) {


            $entity = $entityManager->getRepository(Cours::class)->find($updateCoursId);


            $entity->setNom($coursEntity->getNom());

            $entity->setImage($coursEntity->getImage());
            $entity->setDescription($coursEntity->getDescription());
            $entity->setTags($coursEntity->getTags());
            $entity->setSubcategoryid($coursEntity->getSubcategoryid());
            $entity->setNiveauid($coursEntity->getNiveauid());


            $slugger = new AsciiSlugger();
            $entity->setSlug($slugger->slug($coursEntity->getNom())->lower());
            $entityManager->persist($entity);


            $RessourceToDelete = $entityManager->getRepository(Ressources::class)->findBy(["coursid" => $updateCoursId]);

            foreach ($RessourceToDelete as $entityR) {
                $entityManager->remove($entityR);
            }


            $LessonsToDelete = $entityManager->getRepository(Lessons::class)->findBy(["coursid" => $updateCoursId]);

            foreach ($LessonsToDelete as $entityL) {
                $entityManager->remove($entityL);
            }


         
            $coursEntity = $entity;
            $this->addFlash('success', 'Le cours a été ajouté avec succès!');
        } else {

            $entityManager->persist($coursEntity);
            $this->addFlash('success', 'Le cours a été modifié avec succès!');
        }


        $ressourceEntity->setCoursid($coursEntity);
        $entityManager->persist($ressourceEntity);
        foreach ($lessonsEntityList as $key=> $lessonItem) {
            $lessonItem->setCoursid($coursEntity);
            $lessonItem->setClassement($key+1);

            $entityManager->persist($lessonItem);
        }
        $entityManager->flush();


        
             
            
        return $this->json(['success' => true, 'message' => 'success','route' => $this->generateUrl('teacher_cours_index')], Response::HTTP_OK);
    }



    public function collectCoursData($formData): Cours
    {

        $user = $this->managerRegistry->getRepository(User::class)->find(3);
        $sousCategory = $this->managerRegistry->getRepository(Souscategorie::class)->find($formData['subCategoryId']);

        $level = $this->managerRegistry->getRepository(Level::class)->find($formData['niveauId']);

        //up top
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
        $entity->setLien($formData['ressource_lien']);
        $entity->setType($formData['ressource_type']);




        return $entity;
    }


    private function validation($coursEntity, $ressourceErrors, $lessonsEntityList, ValidatorInterface $validator)
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
                if($propertyPath == 'lien' || $propertyPath == 'type'){
                    $propertyPath = 'ressource_'.$propertyPath;
                }
                $message = $error->getMessage();
                $formErrors[$propertyPath] = $message;
            }
        }



        foreach ($lessonsEntityList as $key => $lessonItem) {
            $lessonErrors = $validator->validate($lessonItem);

       
            if (count($lessonErrors) > 0) {

                foreach ($lessonErrors as $error) {

           

                    $propertyPath = $error->getPropertyPath();
                    if($propertyPath == 'titre' || $propertyPath == 'video' || $propertyPath == 'content' || $propertyPath == 'duree' || $propertyPath == 'classement'){
                        $propertyPath = 'lesson_'.$propertyPath;
                    }
                    $message = $error->getMessage();
                    $formErrors[$propertyPath][$key] = $message;
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
            $entity->setDuree((int)$request->request->get('lesson_duree')[$i]);
            $entity->setClassement((int)$request->request->get('lesson_classement')[$i]);

            $lessons[] = $entity;
        }






        return $lessons;
    }




    public function delete($id): Response
    {

        $entityManager = $this->managerRegistry->getManager();

        $entity = $entityManager->getRepository(Cours::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Entity not found');
        }

        $entityManager->remove($entity);

        $entityManager->flush();

        return $this->redirectToRoute('teacher_cours_index');
    }


    public function edit($id): Response
    {

        $entityManager = $this->managerRegistry->getManager();

        $entity = $entityManager->getRepository(Cours::class)->findOneBy(['id' => $id]);
        return $this->render('teacher/cours/add/index.html.twig', [
            'edit_cours' => $entity,
        ]);
    }
}
