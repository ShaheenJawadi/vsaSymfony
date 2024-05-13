<?php

namespace App\Controller\Quiz;

use App\Entity\Notes;
use App\Entity\Quiz;
use App\Entity\User;
use App\Repository\CoursRepository;
use App\Repository\NotesRepository;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\UserRepository;
use App\Service\UserSessionManager;
use App\Services\PdfService;
use Doctrine\Persistence\ManagerRegistry;

class QuizController extends AbstractController
{
    private $managerRegistry;
    private $userSession;
    private $c;


    public function __construct(UserSessionManager $userSession, ManagerRegistry $managerRegistry) 
    {
        $this->userSession = $userSession;
        $this->managerRegistry = $managerRegistry;
        $this->c=0;
    }

    public function index(Request $request, QuizRepository $quizRepository, UserRepository $userRepository,CoursRepository $coursRep): Response
    {
        //$user = $userRepository->find(3); // TODO FIXME: userid
        // $this->userSession->clearSession();
        $user=$this->userSession->getCurrentUser();       
         if (!$user) {
            throw $this->createNotFoundException('No user found');
        }

        $userId = $user->getId();
        $this->c = $request->getSession()->get('c_value', 0);

     $coursId=$this->c;   // TODO FIXME: coursid
    
       
        $questionIndex = $request->attributes->get('questionIndex'); 
        if ($questionIndex === null) {
            $questionIndex = 0;
        } else {
            $questionIndex = (int) $questionIndex; 
        } 
    $quiz = $quizRepository->findQuizByCoursId($coursId);
    //dd($quiz);
    $questionDetails = $this->fetchQuestionDetails($quizRepository,$coursId, $questionIndex,$userId);

    return $this->render('home/quiz/index.html.twig', [
        'controller_name' => 'QuizController',
        'questionDetails' => $questionDetails,
        'quizz' => $quiz,
        'coursId'=>$coursId,
        'userId'=>$userId
        
    ]);

}

public function pdf($quizId, PdfService $pdf, QuizRepository $quizRepository, NotesRepository $notesRepository): Response {
    $quiz = $quizRepository->find($quizId);
    if (!$quiz) {
        throw $this->createNotFoundException('Quiz not found');
    }

    $user=$this->userSession->getCurrentUser();       
         if (!$user) {
            throw $this->createNotFoundException('No user found');
        }

        $userId = $user->getId();
    $note = $notesRepository->findOneBy(['quizid' => $quiz, 'userid' => $userId]);

    $html = $this->renderView('home/quiz/pdf.html.twig', [
        'quiz' => $quiz,
        'note' => $note,
    ]);
    $filename = 'quiz_'.$quiz->getNom().'.pdf'; 
    $binaryPdf = $pdf->generateBinaryPDF($html);

    return new Response(
        $binaryPdf,
        200,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]
    );
}

    private function fetchQuestionDetails(QuizRepository $quizRepository, int $coursId, int $questionIndex,int $userId)
    {
        $quizzes = $quizRepository->findQuizByCoursId($coursId,$userId);

        if (empty($quizzes)) {
            return null;
        }

        $quiz = $quizzes[0]; 
        $questions = $quiz->getQuestions();

        if ($questionIndex < 0 || $questionIndex >= count($questions)) {
            return null;
        }

        $currentQuestion = $questions[$questionIndex];
        $isLastQuestion = ($questionIndex + 1 === count($questions));

        return [
            'quiz' => $quiz,
            'currentQuestion' => $currentQuestion,
            'currentQuestionIndex' => $questionIndex,
            'isLastQuestion' => $isLastQuestion,
            'totalQuestions' => count($questions),
        ];
    }
    public function test(Request $request, int $id){
        $this->c =$id;
        $request->getSession()->set('c_value', $this->c);
        return $this->redirectToRoute('home_quizz_index');
    }

    public function note(Request $request, $quizId): Response
    {
        
        $session = $request->getSession();
        $score = $session->get('quizScore', 'Not available');
    
        return $this->render('home/quiz/note.html.twig', [
            'score' => $score,
            'quizId'=>$quizId
            
        ]);
    }
     public function submitQuizScore(Request $request, ManagerRegistry $manager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $score = $data['score'];
        $quizId = $data['quizId'];
        $userId = $data['userId'];

        $em = $manager->getManager();

        $user = $em->getRepository(User::class)->find($userId);
        $quiz = $em->getRepository(Quiz::class)->find($quizId);

        if (!$user || !$quiz) {
            return new JsonResponse(['status' => 'error', 'message' => 'User or quiz not found'], 404);
        }

         $note = $em->getRepository(Notes::class)->findOneBy(['userid' => $user, 'quizid' => $quiz]);

         if (!$note) {
            $note = new Notes();
            $note->setUserid($user);
            $note->setQuizid($quiz);
         }

        $note->setNote($score);

        $em->persist($note);
        $em->flush();

        $session = $request->getSession();
        $session->set('quizScore', $score);
        $session->set('quizId', $quizId);

        return new JsonResponse(['status' => 'success']);
    }

}
