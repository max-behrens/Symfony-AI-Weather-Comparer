<?php

// src/Form/TaskType.php

namespace App\Form;

use App\Entity\Calculation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('calculation', TextType::class, [
                'attr' => [
                    'class' => 'block w-full mt-1 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2'
                ],
                'label' => 'Calculation', // Customize label if needed
            ])
            ->add('dueDate', DateType::class, [
                'widget' => 'single_text', // Use a single input field for date
                'attr' => [
                    'class' => 'block w-full mt-1 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2'
                ],
                'label' => 'Due Date',
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75'
                ],
                'label' => 'Save Calculation',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Calculation::class,
            'csrf_protection' => true,  // Ensure CSRF protection is enabled
        ]);
    }
}
