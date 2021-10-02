<?php
    
namespace App\Form;

use App\Entity\Category;
use App\Entity\Technique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;



class SearchTableauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
            ->add('category', EntityType::class,
            [ 'class'=>Category::class, 'choice_label'=> 'name',
                'label'=>'Sélectionnez votre thème',
                'attr' =>  ['placeholder'=> true]] )
            ->add('technique', EntityType::class,
            [ 'class'=>Technique::class, 'choice_label'=> 'nom',
                'label'=>'Sélectionnez une technique de peinture'])
            ->add('recherche', SubmitType::class)

                ;

    }


}