<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $amsterdam = new User();
        $amsterdam->setNom('Amsterdam');
        $amsterdam->setPrenom('2019');
        $amsterdam->setPassword("true");
        $manager->persist($amsterdam);

        $manager->flush();
    }
}
