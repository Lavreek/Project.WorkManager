<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('attribute', ChoiceType::class, [
                'label' => false,
                'choices'  => [
                    'Код SAP' => 'CodeSAP',
                    'Код' => 'Code',
                    'Описание' => 'Description',
                    'Мин. кол./упаковка' => 'MinStakePackage',
                    'На складе' => 'Warehouse',
                    'Следующая поставка' => 'NextDelivery',
                    'Цена без НДС' => 'PriceWithoutNDS',
                    'НДС' => 'NDS',
                    'Цена с НДС' => 'PriceWithNDS',
                    'Был обновлён' => 'Updated',
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
                'row_attr' => [
                    'class' => 'me-2'
                ]
            ])
            ->add('search', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'search',
                    'placeholder' => 'Поиск',
                    'aria-label' => 'Поиск'
                ],
                'row_attr' => [
                    'class' => 'me-2'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Поиск",
                'attr' => [
                    'class' => 'btn btn-outline-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'attr' => [
                'class' => 'd-flex'
            ],
            // Configure your form options here
        ]);
    }
}
