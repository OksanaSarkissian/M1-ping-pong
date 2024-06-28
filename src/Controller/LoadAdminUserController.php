<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class LoadAdminUserController extends AbstractController
{
    public $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    #[Route('/fixtures', name: 'app_load_admin_user')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $jane = new User();
        $jane->setNom('Doe');
        $jane->setPrenom('jane');
        $encodedPassword = $this->passwordHasher->hashPassword($jane, "true");
        $jane->setPassword($encodedPassword);
        $jane->setRoles(['ROLE_ADMIN']);
        $jane->setIdentifiant('D.jane');
        $entityManager->persist($jane);

        $entityManager->flush();
        return $this->render('load_admin_user/index.html.twig', [
            'controller_name' => 'LoadAdminUserController',
        ]);
    }
}
