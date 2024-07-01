<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Document;
use App\Entity\LigneDocument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('type')
            ->add('montant_total')
            ->add('delai', null, [
                'widget' => 'single_text',
            ])
            ->add('document', EntityType::class, [
                'class' => Document::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('documents', EntityType::class, [
                'class' => Document::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'id',
            ])
            ->add('ligne_document', EntityType::class, [
                'class' => LigneDocument::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
