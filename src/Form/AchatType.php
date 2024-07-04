<?php

namespace App\Form;

use App\Entity\Achat;
use App\Entity\Fournisseur;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\LigneAchatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
                'data' => new \DateTimeImmutable(),
            ])
            ->add('livraison_prevue', null, [
                'widget' => 'single_text',
            ])
            ->add('livraison_reelle', null, [
                'widget' => 'single_text',
            ])
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'raison_sociale',
            ])
            ->add('ligneAchats', CollectionType::class, [
                'entry_type' => LigneAchatType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Achat::class,
        ]);
    }
}
