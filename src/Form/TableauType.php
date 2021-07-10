<?php

namespace App\Form;

use App\Entity\Tableaux;
use App\Entity\Category;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceLabel;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tableaux::class,
        ]);
    }
}
