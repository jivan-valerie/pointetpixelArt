<?php

namespace App\Form;

use App\Entity\Tableaux;
use App\Entity\Category;
use App\Entity\Technique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceLabel;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class TableauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('titre')
            ->add('auteur')
            ->add('description')
            ->add('image', FileType::class,[
                'label' => 'Télécharger une image',
                'data_class'=> null
            ])
            ->add('longueur')
            ->add('largeur')
            
            ->add('category', EntityType::class,
            [ 'class'=>Category::class, 'choice_label'=> 'name'])
            ->add('technique', EntityType::class,
            [ 'class'=>Technique::class, 'choice_label'=> 'nom'])

            ->add('certifie', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Je certifie être le propriétaire légal et légitime de cette oeuvre'])

            ->add('certifie2', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Je m\'engage à respecter les conditions de vente de Point&Pixel'])

            ->add('certifie3', CheckboxType::class, [
                    'mapped' => false,
                    'label' => 'Je certifie respecter la propriété intellectuelle de cette oeuvre'])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Accepter les termes',
                
                // 'attr'=> ['html'=> '<a href="">vous devez imperativement</a>'],
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            // ->add('ajouter', SubmitType::class, [
            //     'label' => 'Ajouter',
            //     'attr'=>[ 'class'=>'favorite styled text-end'], 
            //     // 'mapped'=>false,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tableaux::class,
        ]);
    }
}
