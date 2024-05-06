<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\ReclamationRepository;
use App\Repository\UserRepository;

class EmailService
{
    private $reclamationRepository;
    private $mailer;
    private $userRepository;

    public function __construct(ReclamationRepository $reclamationRepository, MailerInterface $mailer, UserRepository $userRepository)
    {
        $this->reclamationRepository = $reclamationRepository;
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
    }

    public function sendEmailToUser(int $userId, int $reclamationId)
    {
        $userEmail = $this->reclamationRepository->findUserEmailByUserIdAndReclamationId($userId, $reclamationId);

        $email = (new Email())
            ->from('leila.zaouali@esprit.tn')
            ->to($userEmail)
            ->subject('Reponse De La Reclamation Envoyee')
            ->text('Votre Reclamtion a ete traiter vous pouver voir la reponse sur notre application  ou site web. Cordialement')
            ->html('<p>Votre Reclamtion a ete traiter vous pouver voir la reponse sur notre application  ou site web. Cordialement</p>');

        $this->mailer->send($email);
    }




    public function sendEmail(int $userId)
    {
        $user = $this->userRepository->find($userId);
        $userEmail = $user->getEmail();
        $token = $user->getStatus(); // Assuming the status field contains the verification token

        $verificationLink = 'http://127.0.0.1:8000/verify?token=' . $token;

        $email = (new Email())
            ->from('leila.zaouali@esprit.tn')
            ->to($userEmail)
            ->subject('Email verification')
            ->text('Please click the following link to verify your email: ' . $verificationLink)
            ->html('<p>Please click the following link to verify your email: <a href="' . $verificationLink . '">' . $verificationLink . '</a></p>');

        $this->mailer->send($email);
    }


    public function sendPasswordResetEmail(int $userId, string $resetToken)
    {
        $user = $this->userRepository->find($userId);
        $userEmail = $user->getEmail();
        $resetLink = 'http://127.0.0.1:8000/password-reset?token=' . $resetToken;

        $email = (new Email())
            ->from('leila.zaouali@esprit.tn')
            ->to($userEmail)
            ->subject('Reset Your Password')
            ->text('Please click the following link to reset your password: ' . $resetLink)
            ->html('<p>Please click the following link to reset your password: <a href="' . $resetLink . '">' . $resetLink . '</a></p>');

        $this->mailer->send($email);
    }
}
