<?php

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
                'required' => false,
                'attr' => [
                    'class' => 'block w-full mt-1 mb-2 bg-gray-700 text-xs text-white border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 placeholder-gray-400',
                    'rows' => '4',
                    'placeholder' => 'Enter the calculations details...',
                ],
                'label' => 'Calculations',
            ])
            ->add('aiResponse', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'block w-full mt-1 mb-2 bg-gray-700 text-xs text-white border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 placeholder-gray-400',
                    'rows' => '4',
                    'placeholder' => 'AI Response information...',
                ],
                'label' => 'AI Response',
            ])
            ->add('country', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'block w-full mt-1 mb-2 bg-gray-700 text-xs text-white border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 placeholder-gray-400',
                    'placeholder' => 'Country related to the data...',
                ],
                'label' => 'Country',
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'mt-2 mb-2 p-2 bg-blue-700 text-xs text-white rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 focus:outline-none',
                ],
                'label' => 'Save Fluctuation Values',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Calculation::class,
            'csrf_protection' => false,
        ]);
    }
}
