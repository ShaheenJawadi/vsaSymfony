<?php
namespace App\Twig;

use App\Service\UserSessionManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction; 

class userExtension extends AbstractExtension
{
    private $userSessionManager;

    public function __construct(UserSessionManager $userSessionManager)
    {
        $this->userSessionManager = $userSessionManager;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getCurrentUser', [$this, 'getCurrentUser']),
        ];
    }

    public function getCurrentUser()
    {
        return $this->userSessionManager->getCurrentUser();
    }
}
