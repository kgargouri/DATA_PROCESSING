<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Produits;
use App\Entity\Ventes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VentesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('n_commande')
            ->add('date_commande', null, [
                'widget' => 'single_text',
            ])
            ->add('canal')
            ->add('quantite')
            ->add('date_livraison', null, [
                'widget' => 'single_text',
            ])
            ->add('client', EntityType::class, [
                'class' => Clients::class,
                'choice_label' => 'id',
            ])
            ->add('produit', EntityType::class, [
                'class' => Produits::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ventes::class,
        ]);
    }
}
