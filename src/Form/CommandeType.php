<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Document;
use App\Entity\LigneDocument;
use App\Entity\Piece;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Repository\LigneDocumentRepository;


class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
                'data' => new \DateTimeImmutable(),
            ])
            ->add('delai', null, [
                'widget' => 'single_text',
                'label' => 'Date de livraison prévu',
                'invalid_message' => 'Veuillez entrer une heure',
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'raison_sociale',
            ])
            ->add('ligneDocument', EntityType::class, [
                'class' => LigneDocument::class,
                'query_builder' => function (LigneDocumentRepository $er) {
                    return $er->createQueryBuilder('q')
                        ->select(' q')
                        ->leftJoin('q.piece', 'p')
                        ->groupBy('q.id, p.libelle_piece')
                        ->orderBy('p.libelle_piece', 'ASC');
                },
                'choice_label' => function ($ligneDocument) {
                    return 'Piece: ' . $ligneDocument->getPiece()->getLibellePiece() . ' Quantité: ' . $ligneDocument->getQuantite() . ' Prix de vente: ' . $ligneDocument->getPrixVente();
                },
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
            'ligneDocument' => null
        ]);
    }
}
