<?php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\ReclamationRepository;

class EmailService
{
    private $reclamationRepository;
    private $mailer;

    public function __construct(ReclamationRepository $reclamationRepository, MailerInterface $mailer)
    {
        $this->reclamationRepository = $reclamationRepository;
        $this->mailer = $mailer;
    }

    public function sendEmailToUser(int $userId, int $reclamationId)
    {
        $userEmail = $this->reclamationRepository->findUserEmailByUserIdAndReclamationId($userId, $reclamationId);
    
        $email = (new Email())
            ->from('leila.zaouali@esprit.tn')
            ->to($userEmail)
            ->subject('Reponse De La Reclamation Envoyee')
            ->text('Votre Réclamtion a été traiter, vous pouver voir la réponse sur notre application  ou site web.                                                                    
             Cordialement')
            ->html('<p>Votre Réclamtion a été traiter, vous pouver voir la réponse sur notre application  ou site web.                                                                           
            Cordialement</p>');
    
        $this->mailer->send($email);
    }
    
}
