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
use Doctrine\ORM\EntityRepository;

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
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->leftJoin('u.gamme', 'gamme')
                    ->where('gamme.piece  is NULL')
                    ->orderBy('gamme.libelle', 'ASC');
                },
                'choice_label' => 'libellepiece',
                'placeholder' => 'Choisissez une piece',
                'required' => false,
            ])
            ->add('Operations', EntityType::class, [
                // Multiple selection allowed
                'multiple' => true,
                // This field shows all the Operation
                'class' => Operation::class,
                'choice_label' => 'libelle'
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
