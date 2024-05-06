<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Service\UserSessionManager;

class GoogleController extends AbstractController
{

    private $user_session;

    public function __construct(UserSessionManager $user_session)
    {

        $this->user_session = $user_session;
    }
    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/register/google", name="register_google_start")
     * @param ClientRegistry $clientRegistry
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        // will redirect to Facebook!
        return $clientRegistry
            ->getClient('google') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect();
    }

    /**
     * After going to Facebook, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     *
     * @Route("/register/google/check", name="register_google_check")
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        
        // Use getUser() instead of !$this->getUser() to check if the user is authenticated
        if ($this->getUser()) {
            $roles = $this->getUser()->getRoles();
            $this->user_session->setCurrentUser($this->getUser());
            var_dump($this->getUser());

            // Check the roles and redirect accordingly
            if (in_array('ROLE_ADMIN', $roles)) {
                return $this->redirectToRoute('base_admin');
            } else {
                return $this->redirectToRoute('home_forum_index');
            }
            

            // Default redirect if none of the roles match
            return $this->redirectToRoute('login_app');
        }

        // Handle the case where getUser() returns null or false
        return new JsonResponse(array('status' => false, 'message' => 'User not found'));
    }
}
