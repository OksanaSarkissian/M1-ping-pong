<?php

namespace App\Form;

use App\Entity\Machine;
use App\Entity\Poste;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PosteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('id_user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nom',
                'multiple' => true,
            ])
            ->add('machines', EntityType::class, [
                'class' => Machine::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'required' => false,
            ])
            ->add('save', SubmitType::class, ['label' => "Enregistrer"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Poste::class,
        ]);
    }
}
