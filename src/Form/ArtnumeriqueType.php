<?php

namespace App\Form;

use App\Entity\Artnumerique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArtnumeriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('auteur')
            ->add('description')
            ->add('iframe',TextType::class, [
                'label' =>'Id video YouTube',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Coisissez un code postal',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Votre ID vidéo doit avoir plus de {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 12,
                    ]),
                ],
                
                
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artnumerique::class,
        ]);
    }
}
