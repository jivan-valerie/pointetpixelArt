<?php

namespace App\Form;

use App\Entity\User;
use Attribute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('code_posta',TextType::class, [
                'label' =>'Code Postal',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Coisissez un code postal',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Votre mot de passe doit avoir plus de {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 5,
                    ]),
                ],
            ])
            ->add('ville')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Rôle' =>[ 
                        'Artiste' => 'ROLE_ARTIST']
                ],
                'expanded' => true,
                'multiple'=> true,
                'attr' => ['class' => 'p-0'],
                    'label' =>'Rôles'
            ])
            
            ->add('email'
            )
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Coisissez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit avoir plus de {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]) 
            ->add('ajouter', SubmitType::class, [
                'label' => 'Confirmez',
                'attr'=>[ 'class'=>'firstitem fs-5'], 
                // 'mapped'=>false,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
