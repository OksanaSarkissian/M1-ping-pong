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


class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
                'data' => new \DateTimeImmutable()
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    "Devis" => 'Devis',
                    "Commande" => 'Commande'
                ],
                'placeholder' => 'Choisissez un type de document',
                'required' => true,
            ])
            ->add('delai', null, [
                'widget' => 'single_text',
                'label'=>'Délai'
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'raison_sociale',
            ])
            ->add('ligneDocument', CollectionType::class, [
                'entry_type' => LigneDocumentType::class,
                'label' => false,
                'allow_add' => true,
            ])
            ->add('montant_total')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
