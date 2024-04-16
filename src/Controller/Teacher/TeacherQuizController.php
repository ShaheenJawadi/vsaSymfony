<?php

namespace App\Controller\Teacher;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Cours;
use App\Entity\Quiz;
use App\Entity\User;
use App\Entity\Questions;
use App\Entity\Suggestion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repository\QuizRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Symfony\Component\HttpFoundation\Request;



class TeacherQuizController extends AbstractController
{

    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }


    public function index(QuizRepository $quizRepository, UserRepository $userRepository): Response
    {
        $quizId = 28;  //TODO FIXME: quizid
        $user = $userRepository->find(3); //TODO FIXME: userid=18
        if (!$user) {
            throw $this->createNotFoundException('No user found');
        }
        $userId = $user->getId();
        $quiz = $quizRepository->find($quizId);
        
        $quiz_all = $quizRepository->findby(['userid'=>$userId]);

        
     
        
        return $this->render('teacher/quiz/index.html.twig', [
            'controller_name' => 'TeacherController',
            'quiz' => $quiz,
            'quizzes' => $quiz_all,
        ]);
    }

    public function add($cours_id): Response
    {

        return $this->render('teacher/quiz/add/index.html.twig', [
            'coursId' => $cours_id,
            'errors'=>[]
            
        ]);
    }

    public function up($quiz_id,QuizRepository $quizRepository): Response
    {
        $quiz = $quizRepository->find($quiz_id);
        return $this->render('teacher/quiz/add/update.html.twig', [
            'quiz_id' => $quiz_id,
            'quiz'=> $quiz,

        ]);
    }

    public function preview(int $quiz_id, QuizRepository $quizRepository): Response
    {

        $quiz = $quizRepository->find($quiz_id);
        $content = $this->renderView('teacher/components/quiz/preview_popup.html.twig', [
            'quiz' => $quiz,

        ]);

        return new Response($content);
    }

    public function deleteQuiz(ManagerRegistry $manager, $idQuiz, QuizRepository $rep)
    {
        $q = $rep->find($idQuiz);
        $em = $manager->getManager();
        $em->remove($q);
        $em->flush();

        return $this->redirectToRoute('teacher_quiz_index');
    }
    public function add_question(): Response
    {
         $q_index = random_int(10, 9999);
        $content = $this->renderView('teacher/components/quiz/single_question_form.html.twig', [
             'q_index' => $q_index
        ]);

        return new Response($content);
    }

    
    public function create(Request $request, ValidatorInterface $validator): Response
    {
        $formData = $request->request->all();
    
        $quiz = new Quiz();
        $quiz->setNom($formData['nom'] ?? null);
        $quiz->setDuree($formData['duree'] ?? null);
    
        $errors = $validator->validate($quiz);
    
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['success' => false, 'message' => 'Validation failed', 'errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }
    
        $questions = (array) $request->request->get('question', []);
        if (empty($questions)) {
            return $this->json(['success' => false,'message' => 'Validation failed', 'errors' => ['Il faut ajouter au moins une question']], Response::HTTP_BAD_REQUEST);
        }
    
        $suggItems = (array)$request->request->get('suggestion', []);
        foreach ($questions as $key => $value) {
            if (empty($value)) {
                return $this->json(['success' => false, 'message' => 'Validation failed', 'errors' => ['La question ne peut pas être vide']], Response::HTTP_BAD_REQUEST);
            }
            $suggestionNotNull = array_filter($suggItems[$key]);
            if (empty($suggItems[$key]) || count($suggestionNotNull) != 4) {
                return $this->json(['success' => false, 'message' => 'Validation failed', 'errors' => ['Tous les suggestions sont obligatoires']], Response::HTTP_BAD_REQUEST);
            }
            
        }
    
        $user = $this->managerRegistry->getRepository(User::class)->find(3);// TODO FIXME:
        $cour = $this->managerRegistry->getRepository(Cours::class)->find($formData['coursId']);
        $quizEntity = new Quiz();
        $quizEntity->setNom($formData['nom']);
        $quizEntity->setDuree($formData['duree']);
        $quizEntity->setCoursid($cour);
        $quizEntity->setUserId($user);
    
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($quizEntity);
    
        foreach ($questions as $key => $value) {
            
            $questionEntity = new QuestionS();
            $questionEntity->setQuestion($value);
            $questionEntity->setUserid($user);
            $questionEntity->setQuizid($quizEntity);
    
            foreach ($suggItems[$key] as $s_key => $s_value) {
                $suggEntity = new Suggestion();
                $suggEntity->setQuestionid($questionEntity);
                $suggEntity->setSuggestion($s_value);
                $suggEntity->setStatus($s_key == 3 ? 1 : 0);
                $entityManager->persist($suggEntity);
            }
    
            $entityManager->persist($questionEntity);
        }
    
        $entityManager->flush();
    
        return $this->json(['success' => true, 'message' => 'Success'], Response::HTTP_OK);
    }
    
  
    public function update(Request $request, ValidatorInterface $validator, $id): Response
{
    $formData = $request->request->all();

    $quiz = new Quiz();
    $quiz->setNom($formData['nom'] ?? null);
    $quiz->setDuree($formData['duree'] ?? null);
    $errors = $validator->validate($quiz);

    if (count($errors) > 0) {
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[] = $error->getMessage();
        }
        return $this->json(['success' => false, 'message' => 'Validation failed', 'errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
    }

    $entityManager = $this->getDoctrine()->getManager();
    $quizEntity = $entityManager->getRepository(Quiz::class)->find($id);
    if (!$quizEntity) {
        return $this->json(['success' => false, 'message' => 'Quiz not found'], Response::HTTP_NOT_FOUND);
    }

    $quizEntity->setNom($formData['nom']);
    $quizEntity->setDuree($formData['duree']);
    $entityManager->persist($quizEntity);
    $entityManager->flush();

    foreach ($formData['questions'] as $questionData) {
        $questionEntity = $entityManager->getRepository(QuestionS::class)->find($questionData['id']);

        if (!$questionEntity) {
            continue; 
        }

        $questionEntity->setQuestion($questionData['question']);
        $entityManager->persist($questionEntity);

        foreach ($questionData['suggestions'] as $suggestionData) {
            $suggestionEntity = $entityManager->getRepository(Suggestion::class)->find($suggestionData['id']);

            if (!$suggestionEntity) {
                continue; 
            }

            $suggestionEntity->setSuggestion($suggestionData['suggestion']);

            $entityManager->persist($suggestionEntity);
        }
    }

    $entityManager->flush();

    return $this->json(['success' => true, 'message' => 'Quiz updated successfully'], Response::HTTP_OK);
}


}