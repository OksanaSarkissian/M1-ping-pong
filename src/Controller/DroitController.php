<?php

namespace App\Controller;

use App\Entity\Droit;
use App\Form\DroitType;
use App\Repository\DroitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/droit')]
class DroitController extends AbstractController
{
    #[Route('/', name: 'app_droit_index', methods: ['GET'])]
    public function index(DroitRepository $droitRepository): Response
    {
        return $this->render('droit/index.html.twig', [
            'droits' => $droitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_droit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $droit = new Droit();
        $form = $this->createForm(DroitType::class, $droit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($droit);
            $entityManager->flush();

            return $this->redirectToRoute('app_droit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('droit/new.html.twig', [
            'droit' => $droit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_droit_show', methods: ['GET'])]
    public function show(Droit $droit): Response
    {
        return $this->render('droit/show.html.twig', [
            'droit' => $droit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_droit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Droit $droit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DroitType::class, $droit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_droit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('droit/edit.html.twig', [
            'droit' => $droit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_droit_delete', methods: ['POST'])]
    public function delete(Request $request, Droit $droit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$droit->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($droit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_droit_index', [], Response::HTTP_SEE_OTHER);
    }
}
