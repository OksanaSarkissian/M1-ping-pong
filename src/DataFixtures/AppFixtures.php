<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Droit;
use App\Entity\User;
use App\Entity\Piece;
use App\Entity\Poste;
use App\Entity\Machine;
use App\Entity\Gamme;
use App\Entity\Operation;
use App\Entity\Realisation;
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
        // droits
        $droit = new Droit();
        $droit->setLibelle('administrateur');
        $manager->persist($droit);

        $ouvrier = new Droit();
        $ouvrier->setLibelle('ouvrier');
        $manager->persist($ouvrier);

        $com = new Droit();
        $com->setLibelle('commercial');
        $manager->persist($com);

        // pièces
        $piece = new Piece();
        $piece->setLibellePiece("roue");
        $piece->setReferencePiece(123456);
        $piece->setPrixU(8.00);
        $piece->setStock(4);
        $manager->persist($piece);

        // poste
        $poste = new Poste();
        $poste->setLibelle("Poste 1");
        $manager->persist($poste);

        // machine
        $machine = new Machine();
        $machine->setLibelle("machine 1");
        $manager->persist($machine);

        
        // operation
        $operation = new Operation();
        $operation->setLibelle("operation 1");
        $operation->setDescription("lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit ametlorem ipsum dolor sit ametlorem ipsum dolor sit amet lorem ipsum dolor sit amet");
        $operation->setMachineId($machine);
        $operation->setPosteId($poste);    
        $operation->setTemps(new \DateTime());
        $manager->persist($operation);

        // user
        $amsterdam = new User();
        $amsterdam->setNom('Amsterdam');
        $amsterdam->setPrenom('2019');
        $encodedPassword = $this->passwordHasher->hashPassword($amsterdam, "true");
        $amsterdam->setPassword($encodedPassword);
        $amsterdam->setRoles(['ROLE_USER']);
        $amsterdam->setIdentifiant('A.2019');
        $manager->persist($amsterdam);
        
        // gamme
        $gamme = new Gamme();
        $gamme->setResponsable($amsterdam);
        $gamme->setPiece($piece);
        $manager->persist($gamme);

        $manager->flush();
        }
}
