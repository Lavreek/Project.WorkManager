<?php

namespace App\Form\Calculator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GasConsumptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gc_q1', NumberType::class, [
                'label' => 'Введите: Q¹',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ]
            ])
            ->add('gc_r0', NumberType::class, [
                'label' => 'Введите: P₀',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ]
            ])
            ->add('gc_r1', HiddenType::class, [
                'attr' => [
                    'value' => '1'
                ]
            ])
            ->add('gc_ro0', NumberType::class, [
                'label' => 'Введите: ρ₀',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ]
            ])
            ->add('gc_ro1', HiddenType::class, [
                'attr' => [
                    'value' => '1.013'
                ]
            ])
            ->add('gc_t0', NumberType::class, [
                'label' => 'Введите: T₀',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ]
            ])
            ->add('gc_t1', HiddenType::class, [
                'attr' => [
                    'value' => '293.15'
                ]
            ])
            ->add('calculate', SubmitType::class, [
                'label' => 'Посчитать',
                'attr' => [
                    'class' => 'btn btn-outline-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
