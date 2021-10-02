<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email',EmailType ::class, [
                'label'=> 'Votre e-mail',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label'=> 'Votre message',
                'attr' => ['rows' => 6],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
