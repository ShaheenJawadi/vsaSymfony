<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                  'label' => 'Nom Categorie',
                  'attr' => [
                      'class' => 'form-control mb-2' // Add classes here
                  ],
                  'required' => true,
                  'constraints' => [
                      new Length([
                        'min' => 2,
                         'minMessage' => 'Le nom de la catégorie doit avoir au moins {{ limit }} caractères.',
                         'max' => 8,
                      'maxMessage' => 'Le nom de la catégorie ne doit pas dépasser {{ limit }} caractères.',
                      ]),
                      new Regex([
                          'pattern' => '/^[a-zA-Z0-9\s]+$/',
                          'message' => 'Le nom de la catégorie ne doit contenir que des lettres, des chiffres ou des espaces.',
                      ]),
                  ],
              ])
              ->add('description', TextType::class, [
                  'label' => 'Description Categorie',
                  'attr' => [
                      'class' => 'form-control custom-class mb-2' // Add multiple classes here
                  ],
                  'required' => true,
              ])
            //->add('lastUpdated')
            /*->add('image', FileType::class, [
                'label' => 'Upload Image',
                'attr' => [
                    'class' => 'form-control custom-class' // Add multiple classes here
                ],
                'mapped' => false, // This is important to prevent Doctrine from trying to persist the image
                'required' => false, // Make the image optional
            ])*/
            //->add('nbsouscategorie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
