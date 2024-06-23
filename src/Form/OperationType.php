<?php

namespace App\Form;

use App\Entity\Machine;
use App\Entity\Operation;
use App\Entity\Poste;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('description')
            ->add('temps', null, [
                'widget' => 'single_text',
            ])
            ->add('poste_id', EntityType::class, [
                'class' => Poste::class,
                'choice_label' => 'libelle',
            ])
            ->add('machine_id', EntityType::class, [
                'class' => Machine::class,
                'choice_label' => 'libelle',
            ])
            ->add('save', SubmitType::class, ['label' => "Créer l'opération"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
