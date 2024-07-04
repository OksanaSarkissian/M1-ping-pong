<?php

namespace App\Controller;

use App\Entity\LigneAchat;
use App\Form\LigneAchatType;
use App\Repository\LigneAchatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ligne/achat')]
class LigneAchatController extends AbstractController
{
    #[Route('/', name: 'app_ligne_achat_index', methods: ['GET'])]
    public function index(LigneAchatRepository $ligneAchatRepository): Response
    {
        return $this->render('ligne_achat/index.html.twig', [
            'ligne_achats' => $ligneAchatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ligne_achat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ligneAchat = new LigneAchat();
        $form = $this->createForm(LigneAchatType::class, $ligneAchat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ligneAchat);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_ligne_achat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ligne_achat/new.html.twig', [
            'ligne_achat' => $ligneAchat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ligne_achat_show', methods: ['GET'])]
    public function show(LigneAchat $ligneAchat): Response
    {
        return $this->render('ligne_achat/show.html.twig', [
            'ligne_achat' => $ligneAchat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ligne_achat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LigneAchat $ligneAchat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LigneAchatType::class, $ligneAchat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ligne_achat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ligne_achat/edit.html.twig', [
            'ligne_achat' => $ligneAchat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ligne_achat_delete', methods: ['POST'])]
    public function delete(Request $request, LigneAchat $ligneAchat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ligneAchat->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ligneAchat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ligne_achat_index', [], Response::HTTP_SEE_OTHER);
    }
}
