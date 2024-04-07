<?php

namespace App\Controller\Teacher;

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
        $quizId = 1;  //TODO FIXME: quizid=1
        $user = $userRepository->find(18); //TODO FIXME: userid=18
        if (!$user) {
            throw $this->createNotFoundException('No user found for id 18');
        }

        $userId = $user->getId();
        $quiz = $quizRepository->getQuizById($quizId);
        $quiz_all = $quizRepository->getAllQuizzesWithDetails($userId);
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

        ]);
    }
    public function preview(int $quiz_id, QuizRepository $quizRepository): Response
    {

        $quiz = $quizRepository->getQuizById($quiz_id);
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


    public function create(Request $request): Response
    {

        $formData = $request->request->all();


        /* add quizzzzzzzzzzzzzzzzzzzzzz */
        $user = $this->managerRegistry->getRepository(User::class)->find(3);
        $cour = $this->managerRegistry->getRepository(Cours::class)->find($formData['coursId']);
        $quizEntity = new Quiz();
        $quizEntity->setNom($formData['nom']);
        $quizEntity->setDuree($formData['duree']);
        $quizEntity->setCoursid($cour);
        $quizEntity->setUserId($user);


        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($quizEntity);
        /* Quizzzzzzzzzzzzzzzzzzzzzzzzzzz */



        $questions = (array) $request->request->get('question', []);
        $suggItems = (array)$request->request->get('suggestion', []);

        foreach ($questions as $key => $value) {
            $questionEntity = new QuestionS();
            $questionEntity->setQuestion($value);
            $questionEntity->setUserid($user);

            $questionEntity->setQuizid($quizEntity);
            $entityManager->persist($questionEntity);

            foreach ($suggItems[$key] as $s_key => $s_value) {
                $suggEntity = new Suggestion();
                $suggEntity->setQuestionid($questionEntity);
                $suggEntity->setSuggestion($s_value);

                if ($s_key == 3) {
                    $suggEntity->setStatus(1);
                } else {
                    $suggEntity->setStatus(0);
                }
                $entityManager->persist($suggEntity);
            }
        }

        $entityManager->flush();







        return $this->json(['success' => true, 'message' => 'success'], Response::HTTP_OK);
    }
}
