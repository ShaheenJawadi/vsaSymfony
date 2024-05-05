<?php

namespace App\Controller\Cours;

use App\Repository\AvisRepository;
use App\Repository\CoursRepository;
use App\Repository\UsercoursRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Usercours;
use App\Repository\LessonsRepository;
use App\Service\UserSessionManager;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UserRepository;

class CoursController extends AbstractController
{

    private $managerRegistry;


    private $userSession;
    public function __construct(UserSessionManager $userSession, ManagerRegistry $managerRegistry)
    {
        $this->userSession = $userSession;
        $this->managerRegistry = $managerRegistry;
    }

    public function coursPage(string $slug, AvisRepository $repo, CoursRepository $coursRepo): Response
    {

        $avis = $repo->getAll();
        $singleCours = $coursRepo->findOneBy(['slug' => $slug]);
        $averageNote = $repo->getAverageNote();
        $countByNote = [
            5 => $repo->getCountByNote(5),
            4 => $repo->getCountByNote(4),
            3 => $repo->getCountByNote(3),
            2 => $repo->getCountByNote(2),
            1 => $repo->getCountByNote(1),
        ];


        return $this->render('home/cours/single/index.html.twig', [
            'singleCours' => $singleCours,
            'avis' => $avis,
            'averageNote' => $averageNote,
            'countByNote' => $countByNote,
        ]);
    }

    public function coursLessonsPage(string $slug, Request $request, UserRepository $userRepository,  CoursRepository $coursRepo, UsercoursRepository $usercoursRepository , LessonsRepository $lessonsRepository): Response
    {

       

        $singleCours = $coursRepo->findOneBy(['slug' => $slug]);
        $user = $this->userSession->getCurrentUser();
        $entityManager = $this->managerRegistry->getManager();
        $checkUserCours = $usercoursRepository->findOneBy(['coursid' => $singleCours->getId(), 'userid' => $user->getId()]);

        if ($checkUserCours == null) {
            $user1 = $userRepository->find($this->userSession->getCurrentUser()->getId());
            $userCoursEntity = new Usercours();
            $userCoursEntity->setCoursId($singleCours);
            $userCoursEntity->setUserId($user1);
            $userCoursEntity->setIsCompleted(false);
            $userCoursEntity->setIscorrectquizz(false);
            $userCoursEntity->setStage(1);
            $userCoursEntity->setEnrollmentDate(new \DateTime());
            $entityManager->persist($userCoursEntity);

            $entityManager->flush();

            return $this->render('home/cours/lessons/index.html.twig', [
                'singleCours' => $singleCours,
                'userCours' => $checkUserCours,
            ]);
        }

        else {
            $l = $request->query->getInt('lesson',1);

          
            if($l>$checkUserCours->getStage() && $l <= $singleCours->getLessons()->count()){
                $checkUserCours->setStage($l);
                $entityManager->persist($checkUserCours);
                $entityManager->flush();
            }
            
        }
        $checkUserCours = $usercoursRepository->findOneBy(['coursid' => $singleCours->getId(), 'userid' => $user->getId()]);
        $currentLesson = $lessonsRepository->findOneBy(['coursid' => $singleCours->getId(), 'classement' => $checkUserCours->getStage()]);

        $next = $lessonsRepository->findOneBy(['coursid' => $singleCours->getId(), 'classement' => $checkUserCours->getStage() + 1]);
        if($next == null){
            $nextLesson = "quiz";
        }
        else {
            $nextLesson = $checkUserCours->getStage() + 1;
        }


        return $this->render('home/cours/lessons/index.html.twig', [
            'singleCours' => $singleCours,
            'userCours' => $checkUserCours,
            'currentLesson'=>$currentLesson,
            'nextLesson'=>$nextLesson,


        ]);
    }
}
