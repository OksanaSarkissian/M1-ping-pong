<?php

namespace App\Form;

use App\Entity\Gamme;
use App\Entity\Piece;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PieceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference_piece')
            ->add('libelle_piece')
            ->add('prix_u')
            ->add('stock')
            ->add('gamme_id', EntityType::class, [
                'class' => Gamme::class,
                'choice_label' => 'id',
            ])
            ->add('composition', EntityType::class, [
                'class' => Piece::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('qtt_piece', EntityType::class, [
                'class' => Piece::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Piece::class,
        ]);
    }
}
