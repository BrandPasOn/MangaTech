<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                ],
                'label_attr' => [
                    'class' => "mt-2 block text-gray-700 text-sm font-bold mb-2"
                ]
            ])
            ->add('first_name', TextType::class, [
                'attr' => [
                    'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                ],
                'label_attr' => [
                    'class' => "mt-2 block text-gray-700 text-sm font-bold mb-2"
                ]
            ])
            ->add('last_name', TextType::class, [
                'attr' => [
                    'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                ],
                'label_attr' => [
                    'class' => "mt-2 block text-gray-700 text-sm font-bold mb-2"
                ]
            ])
            ->add('birthdate', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'shadow text-center appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                ],
                'label_attr' => [
                    'class' => "mt-2 block text-gray-700 text-sm font-bold mb-2"
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'first_options'  => [
                    'label' => 'Password',
                    'attr' => [
                        'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                    ],
                    'label_attr' => [
                        'class' => "mt-2 block text-gray-700 text-sm font-bold mb-2"
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation Password',
                    'attr' => [
                        'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                    ],
                    'label_attr' => [
                        'class' => "mt-2 block text-gray-700 text-sm font-bold mb-2"
                    ]
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
