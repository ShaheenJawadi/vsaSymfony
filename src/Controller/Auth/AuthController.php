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
use App\Service\UserSessionManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Karser\Recaptcha3Bundle\Service\Recaptcha3;
use ReCaptcha\ReCaptcha;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use App\Service\EmailService;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;
use VictorPrdh\RecaptchaBundle\Validator\Recaptcha2Validator;


class AuthController extends AbstractController
{
    private $logger;
    private $user_session;
    private $buttonClass;
    public function __construct(UserSessionManager $user_session, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->user_session = $user_session;
    }



    public function loadLoginPopup(): Response
    {

        $content = $this->renderView('home/auth/popup/login.html.twig');

        return new Response($content);
    }



    public function loadRegisterPopup(Request $request, ManagerRegistry $manager): Response
    {
        $content = $this->renderView(
            'home/auth/popup/register.html.twig'
        );
        return new Response($content);
    }



    public function loadResetPwsPopup(): Response
    {

        $content = $this->renderView('home/auth/popup/resetPws.html.twig');
        return new Response($content);
    }

    /* public function register(Request $request, ManagerRegistry $managerRegistry)
    {

        $formData = $request->request->all();


        $userEntity = new User();
        $userEntity->setNom($formData["nom"]);
        $userEntity->setPrenom($formData["prenom"]);
        $userEntity->setUsername($formData["username"]);
        $userEntity->setEmail($formData["email"]);
        $userEntity->setPassword($formData["password"]);

        // $formData["repreta_password"]
        if ($formData["repreta_password"] != $formData["password"]) {
            $disableRegisterButton = true;
            $buttonClass = "btn_main disabled";
        } else {
            $disableRegisterButton = false;
            $buttonClass = "btn_main";
        }

        $entityManager = $managerRegistry->getManager();
        $entityManager->persist($userEntity);



        $entityManager->flush();
        return $this->redirectToRoute('home_index');
    } */

    public function register(Request $request, ManagerRegistry $managerRegistry, ValidatorInterface $validator)
    {

        $formData = $request->request->all();
        // Validate the reCAPTCHA response
        $recaptchaResponse = $formData['g-recaptcha-response'];
        $recaptcha = new \ReCaptcha\ReCaptcha('6LdvDcspAAAAAJHEwXnr7S1CaKuMcJUh4EUrZylj');
        $resp = $recaptcha->verify($recaptchaResponse, $request->getClientIp());

        if (!$resp->isSuccess()) {
            return new Response('Invalid reCAPTCHA response');
        }

        $userEntity = new User();
        $userEntity->setNom($formData["nom"]);
        $userEntity->setPrenom($formData["prenom"]);

        $userEntity->setUsername($formData["username"]);
        $userEntity->setEmail($formData["email"]);
        $hashedPassword = password_hash($formData["password"], PASSWORD_DEFAULT);
        if ($formData["repreta_password"] == $formData["password"]) {
            $userEntity->setPassword($hashedPassword);
        } else {
            return new Response("Passwords don't match");
        }


        $errors = $validator->validate($userEntity);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        $entityManager = $managerRegistry->getManager();
        $entityManager->persist($userEntity);
        $entityManager->flush();
        // Send a verification email

        return $this->redirectToRoute('home_index');
    }



    /*
    public function login(Request $request, ManagerRegistry $managerRegistry, UserRepository $userRepository)
    {

        $formData = $request->request->all();

        $username = $formData["username"];
        $pws = $formData["password"];

        $usr = $userRepository->findOneBy(['username' => $username]);
        $this->logger->info("11111111111", [$usr]);
        if ($usr && $usr->getPassword() == $pws) {
            $this->user_session->setCurrentUser($usr);
            return $this->redirectToRoute('home_index');
        } else {
            var_dump('error');
        }
    }
    */

    public function login(Request $request, ManagerRegistry $managerRegistry, UserRepository $userRepository)
    {

        $formData = $request->request->all();
        // Validate the reCAPTCHA response


        $username = $formData["username"];
        $pws = $formData["password"];
        $hashedPassword = password_hash($pws, PASSWORD_DEFAULT);


        $usr = $userRepository->findOneBy(['username' => $username]);

        if ($usr && password_verify($pws, $usr->getPassword())) {


            $this->user_session->setCurrentUser($usr);


            return $this->redirectToRoute('home_forum_index');
        } else {
            dd('error');
        }
    }

    /* public function login(Request $request, ManagerRegistry $managerRegistry, UserRepository $userRepository, Recaptcha3 $recaptcha)
    {
        $formData = $request->request->all();

        $username = $formData["username"];
        $pws = $formData["password"];
        $captcha = $formData['g-recaptcha-response']; // This should be the name of your Recaptcha field in your form

        // Validate the Recaptcha response
        if (!$recaptcha->verify($captcha, 'login')) { // 'login' should be the action name you set when you rendered the Recaptcha widget in your form
            dd('Invalid Recaptcha');
        }

        $usr = $userRepository->findOneBy(['username' => $username]);
        if ($usr && $usr->getPassword() == $pws) {
            $this->user_session->setCurrentUser($usr);

            return $this->redirectToRoute('home_forum_index');
        } else {
            dd('error');
        }
    } */




    public function logout(Request $request, ManagerRegistry $managerRegistry, UserRepository $userRepository)
    {

        $this->user_session->clearSession();

        return $this->redirectToRoute('home_index');
    }
}
