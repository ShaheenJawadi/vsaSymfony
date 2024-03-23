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
        $userData = serialize($user);
        $this->session->set('current_user_data', $userData);
    }

    public function getCurrentUser(): ?User
    {

        $userData = $this->session->get('current_user_data');
        if ($userData) {
            // Unserialize the user data to get the user object
            return unserialize($userData, ['allowed_classes' => [User::class]]);
        }

        return null;
    }

    public function clearSession()
    {
        $this->session->remove('current_user_data');
    }

    public function isUserLoggedIn(): bool
    {
        return $this->session->has('current_user_data');
    }
}
