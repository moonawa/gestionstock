<?php

namespace App\Form;

use App\Entity\Entree;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder 
            ->add('dateE', DateType::class, array('label' => 'Date de l\'achat', 'attr'=>array('required'=>'required', 'class'=>'form-control form-group')))
            ->add('qtE', NumberType::class, array('label'  => 'Quantité Acheté', 'attr'=>array('required'=>'required', 'class'=>'form-control form-group')))
            ->add('priuni', NumberType::class, array('label'  => 'Prix Unitaire', 'attr'=>array('required'=>'required', 'class'=>'form-control form-group')))
            ->add('produit',  EntityType::class, array('class'=>Produit::class, 'label'=>'libellé du produit' , 'attr'=>array('required'=>'required', 'class'=>'form-control form-group')))
            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entree::class,
        ]);
    }
}
