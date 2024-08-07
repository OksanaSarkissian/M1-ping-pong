<?php

namespace App\Form;

use App\Entity\Gamme;
use App\Entity\Piece;
use App\config\TypeEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use App\Repository\PieceRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;

class PieceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ref_piece')
            ->add('libelle_piece')
            ->add('prix_unitaire')
            ->add('stock')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    "Livrable" => 'Livrable',
                    "Intermediaire" => 'Intermediaire',
                    "Matiere Premiere" => 'Matiere Premiere',
                    "Achete" => 'Achetée'
                ],
                'placeholder' => 'Choisissez un type de pièce',
                'required' => true,
            ])
            ->add('gamme', EntityType::class, [
                'class' => Gamme::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('gamme')
                        ->where('gamme.piece  is NULL')
                        ->orderBy('gamme.libelle', 'ASC');
                },
                'choice_label' => 'libelle',
                'placeholder' => 'Choisissez une gamme',
                'required' => false,
            ])

            ->add('composition', EntityType::class, [
                'class' => Piece::class,
                'choice_label' => 'libelle_piece',
                'multiple' => true,
                'required' => false,
                'query_builder'=>function (PieceRepository $er) {
                    return $er->createQueryBuilder('piece')
                    ->where('piece.type NOT LIKE \'Livrable\'')
                    ->orderBy('piece.libelle_piece', 'ASC');
                }
            ])
            ->add('save', SubmitType::class, ['label' => "Enregistrer"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Piece::class,
        ]);
    }
}
