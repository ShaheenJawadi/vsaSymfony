<?php
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RecaptchaType;

class TaskController extends AbstractController
{
    public function new(Request $request, Recaptcha3Validator $recaptcha3Validator): Response
    {
        //...
        $form = $this->createForm(RecaptchaType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //...
            $score = $recaptcha3Validator->getLastResponse()->getScore();
            //...
        }
        //...
    }
}