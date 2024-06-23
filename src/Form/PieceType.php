<?php

namespace App\Form;

use App\Entity\Gamme;
use App\Entity\Piece;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PieceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ref_piece')
            ->add('libelle_piece')
            ->add('prix_unitaire')
            ->add('stock')
            ->add('gamme', EntityType::class, [
                'class' => Gamme::class,
                'choice_label' => 'id',
            ])
            // ->add('composition', EntityType::class, [
            //     'class' => Piece::class,
            //     'choice_label' => 'composition',
            //     'multiple' => true,
            // ])
            ->add('save', SubmitType::class, ['label' => "Créer la pièce"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Piece::class,
        ]);
    }
}
