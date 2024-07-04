<?php

namespace App\Controller;

use App\Entity\Gamme;
use App\Form\GammeType;
use App\Repository\GammeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/atelier/gamme')]
class GammeController extends AbstractController
{

    #[Route('/', name: 'app_gamme_index', methods: ['GET'])]
    public function index(GammeRepository $gammeRepository, UserInterface $user): Response
    {
        $id = $this->getUser()->getId();
        return $this->render('gamme/index.html.twig', [
            'gammes' => $gammeRepository->findAll(),
            'active' => 'gamme',
            'connectedUser' => $id
        ]);
    }

    #[Route('/respo/new', name: 'app_gamme_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gamme = new Gamme();
        $form = $this->createForm(GammeType::class, $gamme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($gamme);
            $entityManager->flush();

            $type = 'success';
            $message = "Gamme créée";
            $this->addFlash($type, $message);
            return $this->redirectToRoute('app_gamme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gamme/new.html.twig', [
            'gamme' => $gamme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gamme_show', methods: ['GET'])]
    public function show(Gamme $gamme): Response
    {
        $id = $this->getUser()->getId();
        return $this->render('gamme/show.html.twig', [
            'gamme' => $gamme,
            'connectedUser' => $id
        ]);
    }

    #[Route('/respo/{id}/edit', name: 'app_gamme_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gamme $gamme, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GammeType::class, $gamme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $type = 'success';
            $message = "Gamme modifiée";
            $this->addFlash($type, $message);
            return $this->redirectToRoute('app_gamme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gamme/edit.html.twig', [
            'gamme' => $gamme,
            'form' => $form,
        ]);
    }

    #[Route('/respo/{id}', name: 'app_gamme_delete', methods: ['POST'])]
    public function delete(Request $request, Gamme $gamme, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $gamme->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($gamme);
            $entityManager->flush();
        }

        $type = 'success';
        $message = "Gamme supprimée";
        $this->addFlash($type, $message);

        return $this->redirectToRoute('app_gamme_index', [], Response::HTTP_SEE_OTHER);
    }
}
