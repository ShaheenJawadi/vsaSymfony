<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class AdminController extends AbstractController
{


    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig');
    }


    public function users(): Response
    {

        return $this->render(
            'admin/users/index.html.twig'
        );
    }

    public function users_list(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();


        $data = array();
        foreach ($users as $user) {
            $u = array($user->getNom(), $user->getPrenom(), $user->getEmail(), $this->generateUrl('admin_delete_user', array("id" => $user->getId())));
            array_push($data, $u);
        }



        return new JsonResponse($data);
    }

    public function delete_user($id, UserRepository $userRepository, ManagerRegistry $manager): Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);


        $em = $manager->getManager();
        $em->remove($user);
        $em->flush();
        return $this->render(
            'admin/users/index.html.twig'
        );
    }
}
