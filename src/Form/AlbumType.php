<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Style;
use App\Entity\Artiste;
use App\Repository\StyleRepository;
use App\Repository\ArtisteRepository;
use PHPUnit\TextUI\CliArguments\Mapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', FileType::class,[
                'mapped'=> false,
                'required' => false,
                'label' => 'Image de l\'album',
                'attr' => [
                    'accept' => '.jpeg, .png, .jpg'
                ],
                'row_attr' => [
                    'class' => 'd-none'
                ],
                'constraints' => [
                    new Image([
                        'maxSize' => '1024k',
                        'maxSizeMessage' => 'Le fichier ne doit pas dépasser 1Mo',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                            'image/PNG',
                        ],
                        'mimeTypesMessage' => 'Merci de choisir un fichier de type jpeg, jpg ou png',
                    ])
                ],
            ])
            ->add('image', HiddenType::class)
            ->add('nom', TextType::class,[
                'label' => 'Nom de l\'album',
                'required'=>'false',
                'attr' => [
                    'placeholder' => 'Saisir le nom de l\'album'
                ]
            ])
            ->add('date', IntegerType::class,[
                'label' => 'Année de sortie',
                'required'=>'false',
                'attr' => [
                    'placeholder' => 'Saisir Année de sortie'
                ]
            ])
            ->add('artiste', EntityType::class,[
                'class' => Artiste::class,
                'query_builder' => function (ArtisteRepository $repo) {
                    return $repo->listeArtisteSimple();
                },
                'choice_label' => 'nom',
                'label' => 'Nom de l\'Artiste',
                'required'=>false,
                'attr' => [
                    'placeholder' => 'Saisir le nom de Artiste'
                ]
            ])
            ->add('styles',EntityType::class,[
                'class' => Style::class,
                'query_builder' => function (StyleRepository $repo) {
                    return $repo->listeStyleSimple();
                },
                'choice_label' => 'nom',
                'label' => 'Style(s)',
                'required'=>false,
                'multiple' => true,
                'by_reference' => false,
                'attr' => [
                    'class' => 'selectStyles',
                ]
            ])
            ->add('morceaux', CollectionType::class,[
                'entry_type' => MorceauType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
        {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
