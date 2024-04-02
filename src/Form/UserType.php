<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, ['attr' => [
                'class' => 'form-control',
                'placeholder' => 'UserName'
            ], 'label' => false, 'required' => false])
            ->add('email', EmailType::class ,['attr' => [
                'class' => 'form-control',
                'placeholder' => 'Email'
            ], 'label' => false, 'required' => false] )
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'password'
                ], 'label' => false, 'required' => false

                // Assuming you handle the password encryption in the controller or event listener
            ])
            ->add('repeatPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'repeat password'
                ], 'label' => false, 'required' => false

                // Assuming you handle the password encryption in the controller or event listener
            ])
            ->add('submit', SubmitType::class, [ 'attr' => [
                'class' => 'btn_main', 
            ],'label' => "S'inscrire"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
