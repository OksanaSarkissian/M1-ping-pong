<?php

namespace App\Form;

use App\Entity\Achat;
use App\Entity\LigneAchat;
use App\Repository\PieceRepository;
use App\Entity\Piece;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class LigneAchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('piece', EntityType::class, [
            'class' => Piece::class,
            'choice_label' => 'libelle_piece',
            'query_builder'=> function (PieceRepository $er) {
                return $er->createQueryBuilder('piece')
                ->where('piece.type NOT LIKE \'Livrable\'')
                ->orderBy('piece.libelle_piece', 'ASC');
            }
        ])
            ->add('prix_catalogue')
            ->add('prix_achat')
            ->add('quantite')
            ->add('delete',ButtonType::class, ['attr' => ['class' => 'delete-achat']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LigneAchat::class,
        ]);
    }
}
