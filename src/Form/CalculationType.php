<?php

// src/Form/CalculationType.php
namespace App\Form;

use App\Entity\Calculation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('calculations', TextareaType::class, [
                'required' => false, // Not required since it may be hidden
                'attr' => [
                    'class' => 'block w-full mt-1 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2',
                    'rows' => '4',
                    'placeholder' => 'Enter the calculations details...',
                ],
                'label' => 'Calculations',
            ])
            ->add('aiResponse', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'block w-full mt-1 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2',
                    'rows' => '4',
                    'placeholder' => 'AI Response information...',
                ],
                'label' => 'AI Response',
            ])
            ->add('country', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'block w-full mt-1 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2',
                    'placeholder' => 'Country related to the data...',
                ],
                'label' => 'Country',
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'mt-2 p-2 bg-blue-500 text-white rounded',
                ],
                'label' => 'Save Fluctuation Values',
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Calculation::class,
            'csrf_protection' => true,
        ]);
    }
}