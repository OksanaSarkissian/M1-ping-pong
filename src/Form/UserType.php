<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('identifiant')
            ->add('password')
            ->add('Roles', ChoiceType::class, [
                'choices' => [
                    "ROLE_ATELIER" => 'ROLE_ATELIER',
                    "ROLE_COMMERCIAL" => 'ROLE_COMMERCIAL',
                    "ROLE_ATELIER_RESPONSABLE" => 'ROLE_ATELIER_RESPONSABLE',
                    "ROLE_ADMIN" => 'ROLE_ADMIN'
                ],
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
