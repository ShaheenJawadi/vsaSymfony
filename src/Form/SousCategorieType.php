<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Souscategorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class SousCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
            'label' => 'Nom Categorie',
                  'attr' => [
                      'class' => 'form-control mb-2' // Add classes here
                  ],
                  'constraints' => [
                      new NotBlank(['message' => 'Le nom de la catégorie est requis.']),
                      new Length([
                          'min' => 2,
                          'max' => 8,
                          'minMessage' => 'Le nom de la catégorie doit avoir au moins {{ limit }} caractères.',
                          'maxMessage' => 'Le nom de la catégorie ne doit pas dépasser {{ limit }} caractères.',
                      ]),  new Regex([
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
            /*->add('image', FileType::class, [
                'label' => 'Upload Image',
                'attr' => [
                    'class' => 'form-control custom-class mb-2' // Add multiple classes here
                ],
                'mapped' => false, // This is important to prevent Doctrine from trying to persist the image
                'required' => false, // Make the image optional
            ])*/
            ->add('status', ChoiceType::class, [
                'label' => 'Status',
                'choices' => [
                    'Active' => 'active',
                    'Inactive' => 'inactive',
                    // Add more status options if needed
                ],
                'placeholder' => 'Select Status',
                'attr' => [
                    'class' => 'form-group form-select mb-2'
                ],
                'required' => true,
            ])
            ->add('categorieid', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'label' => 'Categorie',
                'placeholder' => 'Select Categorie',
                'required' => true,
                'attr' => [
                    'class' => 'form-group form-select mb-2'
                ],
                   'constraints' => [
                            new NotBlank(['message' => 'La catégorie est requise.']),
                        ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Souscategorie::class,
        ]);
    }
}
