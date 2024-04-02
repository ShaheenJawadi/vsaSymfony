<?php
namespace App\Controller\Teacher;

use App\Entity\Quiz; // Assurez-vous d'importer l'entité Quiz
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException; // Importez cette classe pour gérer les cas où le quiz n'est pas trouvé
use App\Repository\QuizRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;



class TeacherQuizController extends AbstractController
{


    public function index(QuizRepository $quizRepository, UserRepository $userRepository): Response
    {
        $quizId = 1; 
        $user = $userRepository->find(18); // FIXME: userid=18
        if (!$user) {
            throw $this->createNotFoundException('No user found for id 18');
        }
    
        $userId = $user->getId();
        $quiz = $quizRepository->getQuizById($quizId);
        $quiz_all= $quizRepository->getAllQuizzesWithDetails($userId);
        return $this->render('teacher/quiz/index.html.twig', [
            'controller_name' => 'TeacherController',
            'quiz' => $quiz,
            'quizzes'=>$quiz_all,
        ]);
    }

    
    public function preview(int $quiz_id, QuizRepository $quizRepository): Response
    {

        $quiz= $quizRepository->getQuizById($quiz_id);
        $content = $this->renderView('teacher/components/quiz/preview_popup.html.twig',[
            'quiz' => $quiz,

        ]);

        return new Response($content);
    }

    public function deleteQuiz(ManagerRegistry $manager,$idQuiz,QuizRepository $rep)
  {
       $q=$rep->find($idQuiz);
       $em=$manager->getManager();
       $em->remove($q);
       $em->flush();
      
      return $this->redirectToRoute('teacher_quiz_index');
  }
  public function add_question(): Response
  {
      $q_index = random_int(10,9999);
      $content = $this->renderView('teacher/components/quiz/single_question_form.html.twig', [
          'q_index'=>$q_index
      ]);

      return new Response($content);
  }


  public function create(Request $request): Response
  {

      $formData = $request->request->all();

      $questionItems = $request->request->get('question', []);

      $suggItems=$request->request->get('suggestion', []);


  

    


      return $this->json(['success' => true, 'message' => 'success'], Response::HTTP_OK);
  }
    
    
}
