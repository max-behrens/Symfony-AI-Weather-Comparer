<?php

// src/Form/WeatherSearchType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeatherSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'label' => 'City',
                'required' => true,
                'attr' => [
                    'class' => 'mt-2 p-2 border border-gray-300 rounded w-full'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Get Weather',
                'attr' => [
                    'class' => 'mt-2 p-2 bg-blue-500 text-white rounded'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'data_class' => null
        ]);
    }
}