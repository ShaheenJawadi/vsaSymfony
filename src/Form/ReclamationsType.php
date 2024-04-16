<?php

namespace App\Form;

use App\Entity\Reclamations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReclamationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('type', ChoiceType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Veuillez sélectionner un type.']),
            ],
            'choices' => [
                'Cours' => 'cours',
                'Note' => 'note',
                'Certificat' => 'certificat',
                'Autre' => 'autre',
            ],
            'placeholder' => 'Choisissez votre type',
        ])
        ->add('description', TextareaType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Veuillez saisir une description.']),
            ],
            'attr' => ['style' => 'height: 100px'],
        ])
        ->add('Envoyer', SubmitType::class, [
            'label' => 'Envoyer',
            'attr' => ['class' => 'btn_main'],
        ])
    ;
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamations::class,
        ]);
    }
}
