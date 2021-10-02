<?php

namespace App\Form;

use App\Entity\Images;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class ImagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('auteur')
            ->add('titre')
            ->add('description')
            ->add('image', FileType::class,[
                'label' => 'Télécharger une image',
                'data_class'=> null
            ])

            ->add('certifie', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Je certifie être le propriétaire légal et légitime de cette oeuvre'])


            ->add('certifie3', CheckboxType::class, [
                    'mapped' => false,
                    'label' => 'Je certifie respecter la propriété intellectuelle de cette oeuvre'])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Accepter les termes',
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
            'data_class' => Images::class,
        ]);
    }
}
