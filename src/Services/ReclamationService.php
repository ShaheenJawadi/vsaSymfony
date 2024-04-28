<?php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\ReclamationRepository;

class ReclamationService
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
            ->text('Votre Reclamtion a ete traiter vous pouver voir la reponse sur notre application  ou site web. Cordialement')
            ->html('<p>Votre Reclamtion a ete traiter vous pouver voir la reponse sur notre application  ou site web. Cordialement</p>');
    
        $this->mailer->send($email);
    }
    
}
