<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Droit;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class AppFixtures extends Fixture
{
    public $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
 
    public function load(ObjectManager $manager): void
    {
        $droit = new Droit();
        $droit->setLibelle('administrateur');
        $manager->persist($droit);

        $amsterdam = new User();
        $amsterdam->setNom('Amsterdam');
        $amsterdam->setPrenom('2019');
        $encodedPassword = $this->passwordHasher->hashPassword($amsterdam, "true");
        $amsterdam->setPassword($encodedPassword);
        $amsterdam->setDroit($droit);
        $amsterdam->setIdentifiant('A.2019');
        $manager->persist($amsterdam);

        $manager->flush();
    }
}
