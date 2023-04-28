<?php

namespace App\Form;

use App\Entity\Serie;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType:: class, [
            'attr' => [
                'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
            ],
            'label_attr' => [
                'class' => "mt-2 block text-gray-700 text-sm font-bold mb-2"
            ]
        ])
            ->add('original_name', TextType:: class, [
            'attr' => [
                'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
            ],
            'label_attr' => [
                'class' => "mt-2 block text-gray-700 text-sm font-bold mb-2"
            ]
        ])
            ->add( 'category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function ($category) {
                    return $category->getName();
                },
                'attr' => [
                    'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                ],
                'label_attr' => [
                    'class' => "mt-2 block text-gray-700 text-sm font-bold mb-2"
                ],
                'placeholder' => 'Choisissez une catégorie'
        ])
            ->add('Enregistrer', SubmitType::class, [
                'attr' => [
                    'class' => 'bg-amber-500 hover:bg-amber-700 text-white font-bold mt-2 py-2 px-4 rounded focus:outline-none focus:shadow-outline'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
