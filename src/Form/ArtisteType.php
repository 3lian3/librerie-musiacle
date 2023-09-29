<?php

namespace App\Form;

use App\Entity\Artiste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArtisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'artiste',
                'attr' => [
                    'placeholder' => 'Saisir le nom de l\'artiste'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de l\'artiste',
                'attr' => [
                    'placeholder' => 'Saisir la description de l\'artiste'
                ]
            ])
            ->add('site', UrlType::class, [
                'label' => 'Site de l\'artiste',
                'attr' => [
                    'placeholder' => 'Saisir site de l\'artiste'
                ]
            ])
            ->add('image', TextType::class, [
                'label' => 'Image de l\'artiste',
                'attr' => [
                    'placeholder' => 'Image de l\'artiste'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de l\'artiste',
                'choices' => [
                    'Groupe' => 1 ,
                    'Solo' => 0 ,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artiste::class,
        ]);
    }
}
