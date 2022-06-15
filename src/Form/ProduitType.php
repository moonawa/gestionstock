<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, array('label'=>'libellé du produit', 'attr'=>array('required'=>'required', 'class'=>'form-control form-group')))
            ->add('qtStock', TextType::class, array('label'=>'Quantité du produit', 'attr'=>array('required'=>'required', 'class'=>'form-control form-group')))
            ->add('categorie',  EntityType::class, array('class'=>Categorie::class, 'label'=>'Nom de la categorie' , 'attr'=>array('required'=>'required', 'class'=>'form-control form-group')))
            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success')))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
