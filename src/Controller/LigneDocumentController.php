<?php

namespace App\Controller;

use App\Entity\LigneDocument;
use App\Form\LigneDocumentType;
use App\Repository\LigneDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ligne/document')]
class LigneDocumentController extends AbstractController
{
    #[Route('/', name: 'app_ligne_document_index', methods: ['GET'])]
    public function index(LigneDocumentRepository $ligneDocumentRepository): Response
    {
        return $this->render('ligne_document/index.html.twig', [
            'ligne_documents' => $ligneDocumentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ligne_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ligneDocument = new LigneDocument();
        $form = $this->createForm(LigneDocumentType::class, $ligneDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ligneDocument);
            $entityManager->flush();

            return $this->redirectToRoute('app_ligne_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ligne_document/new.html.twig', [
            'ligne_document' => $ligneDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ligne_document_show', methods: ['GET'])]
    public function show(LigneDocument $ligneDocument): Response
    {
        return $this->render('ligne_document/show.html.twig', [
            'ligne_document' => $ligneDocument,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ligne_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LigneDocument $ligneDocument, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LigneDocumentType::class, $ligneDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ligne_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ligne_document/edit.html.twig', [
            'ligne_document' => $ligneDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ligne_document_delete', methods: ['POST'])]
    public function delete(Request $request, LigneDocument $ligneDocument, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ligneDocument->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ligneDocument);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ligne_document_index', [], Response::HTTP_SEE_OTHER);
    }
}
