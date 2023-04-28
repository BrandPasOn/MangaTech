<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CategoryType extends AbstractType
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
            ->add('description', TextareaType:: class, [
            'attr' => [
                'class' => 'shadow appearance-none border rounded w-full h-60 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
            ],
            'label_attr' => [
                'class' => "mt-2 block text-gray-700 text-sm font-bold mb-2"
            ]
        ])
            ->add('Enregistrer', SubmitType:: class, [
            'attr' => [
                'class' => 'bg-amber-500 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
