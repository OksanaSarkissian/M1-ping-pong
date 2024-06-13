<?php

namespace App\Form;

use App\Entity\Machine;
use App\Entity\Piece;
use App\Entity\Poste;
use App\Entity\Realisation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RealisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('temps_reel', null, [
                'widget' => 'single_text',
            ])
            ->add('poste_id_reel', EntityType::class, [
                'class' => Poste::class,
                'choice_label' => 'id',
            ])
            ->add('machine_id_reel', EntityType::class, [
                'class' => Machine::class,
                'choice_label' => 'id',
            ])
            ->add('piece', EntityType::class, [
                'class' => Piece::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Realisation::class,
        ]);
    }
}
