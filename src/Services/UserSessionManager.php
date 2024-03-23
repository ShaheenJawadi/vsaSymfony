<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserSessionManager
{
    private $session;
    private $entityManager;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function setCurrentUser(User $user)
    {
        $this->session->set('current_user_id', $user->getId());
    }

    public function getCurrentUser(): ?User
    {
        $userId = $this->session->get('current_user_id');
        if ($userId) {
            return $this->entityManager->getRepository(User::class)->find($userId);
        }
        return null;
    }

    public function clearSession()
    {
        $this->session->remove('current_user_id');
    }

    public function isUserLoggedIn(): bool
    {
        return $this->session->has('current_user_id');
    }
}
