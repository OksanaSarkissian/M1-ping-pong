<?php

namespace App\Form;

use App\Entity\Gamme;
use App\Entity\Piece;
use App\Entity\User;
use App\Entity\Operation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\UserRepository;

class GammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('responsable', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'FullName',
                'query_builder' => function (UserRepository $r) {
                    return $r->findByRole('ROLE_ATELIER_RESPONSABLE');
                },
                'placeholder' => 'Choisissez un responsable',
                'required' => true,

            ])
            ->add('piece', EntityType::class, [
                'class' => Piece::class,
                'choice_label' => 'libellepiece',
                'placeholder' => 'Choisissez une piece',
                'required' => false,
            ])
            ->add('Operation', EntityType::class, [
                // Multiple selection allowed
                'multiple' => true,
                // This field shows all the Operation
                'class' => Operation::class,
                'choice_label' => 'libelle',
                'mapped' => false
            ])
            ->add('save', SubmitType::class, ['label' => "Enregistrer"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gamme::class,
        ]);
    }
}
