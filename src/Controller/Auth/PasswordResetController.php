<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\EmailService;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class PasswordResetController extends AbstractController // Extends AbstractController
{
    private $emailService;
    private $userRepository;
    private $entityManager; // Entity manager injected

    public function __construct(EmailService $emailService, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->emailService = $emailService;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/password-reset-request", name="password_reset_request", methods={"POST"})
     */
    public function requestReset(Request $request): Response
    {
        $email = $request->request->get('email');
        $user = $this->userRepository->findOneByEmail($email);

        if (!$user) {
            // Optionally, return to the form with an error message
            return $this->render('home/auth/popup/resetPws.html.twig', [
                'error' => 'No user found for this email'
            ]);
        }

        // Generate a reset token
        $resetToken = bin2hex(random_bytes(32));
        $user->setToken($resetToken);
        // Optionally set an expiration time for the token here if applicable

        // Use the injected entity manager to persist and flush the changes
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Send the password reset email using the EmailService
        $this->emailService->sendPasswordResetEmail($user->getId(), $resetToken);

        // Return success message
        // return $this->render('home/auth/popup/resetPws.html.twig', [
        //   'message' => 'Reset password email sent'
        //]);


        return $this->redirectToRoute('home_forum_index');
    }

    /**
     * @Route("/password-reset", name="password_reset", methods={"GET"})
     */
    public function showResetForm(): Response
    {
        // Return your form view here

        return $this->render('reset_password_form.html.twig');
    }
    /**
     * @Route("/submit-new-password", name="submit_new_password", methods={"POST"})
     */
    public function submitNewPassword(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $newPassword = $request->request->get('newPassword');
        $repeatNewPassword = $request->request->get('repeatNewPassword');

        if ($newPassword !== $repeatNewPassword) {
            // Handle the error scenario where passwords do not match
            return $this->render('reset_password_form.html.twig', [
                'error' => 'Passwords do not match.',
            ]);
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $user = $this->userRepository->findOneByToken($request->request->get('token'));
        $user->setPassword($hashedPassword);
        $user->setToken(null); // Clear the token after successful password reset
        $entityManager = $managerRegistry->getManager();
        $entityManager->persist($user);
        $entityManager->flush();;

        return $this->redirectToRoute('home_forum_index'); // Redirect to a route after successful password update
    }
}
