<?php

namespace App\Form;

use App\Entity\Machine;
use App\Entity\User;
use App\Entity\Piece;
use App\Entity\Poste;
use App\Entity\Realisation;
use App\Entity\Operation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Security\Core\Security;

class RealisationType extends AbstractType
{
    private $security;
    public function __construct(Security $security) {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $user = $this->security->getUser();
        // dump($user);
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
                'data' => new \DateTime()
            ])
            ->add('ouvrier', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'identifiant',
                'data'=>$user,
            ])
            ->add('operation', EntityType::class, [
                'class' => Operation::class,
                'choice_label' => 'libelle',
                'data'=>$options['operation'],
            ])
            ->add('temps_reel', null, [
                'widget' => 'single_text',
            ])
            ->add('poste_reel', EntityType::class, [
                'class' => Poste::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Choisissez un poste',
            ])
            ->add('machine_reel', EntityType::class, [
                'class' => Machine::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Choisissez une machine',
            ])
            ->add('piece', EntityType::class, [
                'class' => Piece::class,
                'choice_label' => 'libellepiece',
                'placeholder' => 'Choisissez une piece',
            ])
            ->add('save', SubmitType::class, ['label' => "Etape suivante"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Realisation::class,
            'operation' => null
        ]);
    }
}
