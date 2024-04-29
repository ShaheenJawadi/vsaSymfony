<?php

namespace App\Form;
use App\Entity\User;

use App\Entity\Publications;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class PublicationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', TextareaType::class,['attr'=>['class' => 'form-control',
        'placeholder' => 'Titre',
        'rows' => 1],'label' => false])

        ->add('contenu', TextareaType::class,['attr'=>['class' => 'form-control',
        'placeholder' => 'Poser votre question',
        'rows' => 2],'label' => false])
        ->add('images', FileType::class, [
            'multiple' => true,
            'required' => false,
            'label' => false,
            'attr' => ['accept' => 'image/*']
        ])

        ->add('submit', SubmitType::class, ['label' => 'Soumettre','attr' => ['class' => 'btn_main']]
         
    );
        
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publications::class,
        ]);
    }
}
