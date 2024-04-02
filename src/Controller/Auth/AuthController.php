<?php

namespace App\Controller\Auth;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use App\Form\UserModifyType;
use App\Repository\UserRepository;

class AuthController extends AbstractController
{

    public function loadLoginPopup(): Response
    {

        $content = $this->renderView('home/auth/popup/login.html.twig');

        return new Response($content);
    }



    public function loadRegisterPopup(Request $request, ManagerRegistry $manager, UserRepository $userRepository): Response
    {

        $form = $this->createForm(UserType::class, new User());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $manager->getManager();
            $user = $form->getData();
       

            // Find the user dynamically, you may have some logic here to find the user
            // For example, if you have the email address of the user, you can find it like this:
            $email = $form->get('email')->getData();
            $userFound = $userRepository->findOneBy(['email' => $email]);

            if (!$userFound) {
                throw $this->createNotFoundException('No user found for the given criteria.');
            }

            // Set the found user
            $user->setUser($userFound);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'User registered successfully.');
            return $this->redirectToRoute('home_forum_index');
        }


        $content = $this->renderView(
            'home/auth/popup/register.html.twig',
            ["formR" => $form->createView()]
        );
        return new Response($content);
    }



    public function loadResetPwsPopup(): Response
    {

        $content = $this->renderView('home/auth/popup/resetPws.html.twig');

        return new Response($content);
    }


    public function modifyUser(Request $request, User $user): Response
    {
        $form = $this->createForm(UserModifyType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'User modified successfully.');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/modify.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function deleteUser(ManagerRegistry $manager, $idUser, PublicationsRepository $rep)
    {
        $user = $rep->find($idUser);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $em = $manager->getManager();
        $em->remove($user);
        $em->flush();

        // Redirect to a suitable route after deletion
        return $this->redirectToRoute('///'); // Replace '///' with the appropriate route
    }
    public function allUsers(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $users;
    }







    public function registerUser(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encoding the password
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));

            // Persisting the user entity
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirect or do something upon successful registration
            return $this->redirectToRoute('home_quizz_index'); // Adjust the route as necessary
        }

        // Render the registration form view
        return $this->render('home/auth/popup/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
