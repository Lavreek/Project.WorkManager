<?php

namespace App\Form\Webinar;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('EmailHash', TextType::class, [
                'label' => 'Ваш электронный адрес',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'e@mail.ru',
                    'autocomplete' => 'off',
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ]
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Отправить',
                'attr' => [
                    'class' => 'btn btn-primary mx-auto'
                ],
                'row_attr' => [
                    'class' => 'd-flex'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Feedback::class,
            'methods' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
