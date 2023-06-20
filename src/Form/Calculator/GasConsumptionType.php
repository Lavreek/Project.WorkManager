<?php

namespace App\Form\Calculator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('gc_ro1', ChoiceType::class, [
                'label' => 'Введите: ρ¹',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'choices' => [
                    'Воздух' => 1,
                    'Аргон (Ar)' => 1.3796,
                    'Аммиак (NH3) (сухой)' => 0.5963,
                    'Бутан (C4H10)' => 2.088,
                    'Углекислый газ (C02)' => 1.529,
                    'Оксид углерода (CO)' => 0.967,
                    'Хлор (CL2) (сухой)' => 2.486,
                    'Этан (C2H6)' => 1.0493,
                    'Ацетилен (C2H2)' => 0.9073,
                    'Этилен (C2H4)' => 0.9749,
                    'Гелий (He)' => 0.138,
                    'Водород (H2)' => 0.0695,
                    'Метан (CH4)' => 0.5544,
                    'Природный газ (типовой)' => 0.65,
                    'Азот (N2)' => 0.9672,
                    'Оксид азота (NO)' => 1.0366,
                    'Закись азота (N2О)' => 1.5297,
                    'Кислород (O2)' => 1.1053,
                    'Пропан (C3H8)' => 1.562,
                    'Пропилен (C3H6)' => 1.452,
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ],
                'attr' => [
                    'class' => 'form-control form-select'
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
