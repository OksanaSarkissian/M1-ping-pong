<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Form\PieceType;
use App\Repository\PieceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/piece')]
class PieceController extends AbstractController
{
    #[Route('/', name: 'app_piece_index', methods: ['GET'])]
    public function index(PieceRepository $pieceRepository): Response
    {
        return $this->render('piece/index.html.twig', [
            'pieces' => $pieceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_piece_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $piece = new Piece();
        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($piece);
            $entityManager->flush();

            $type = 'success';
            $message = "Pièce créée";
            $this->addFlash($type, $message);
            return $this->redirectToRoute('app_piece_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('piece/new.html.twig', [
            'piece' => $piece,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_piece_show', methods: ['GET'])]
    public function show(Piece $piece): Response
    {
        return $this->render('piece/show.html.twig', [
            'piece' => $piece,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_piece_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Piece $piece, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $type = 'success';
            $message = "Pièce modifiée";
            $this->addFlash($type, $message);
            return $this->redirectToRoute('app_piece_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('piece/edit.html.twig', [
            'piece' => $piece,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_piece_delete', methods: ['POST'])]
    public function delete(Request $request, Piece $piece, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $piece->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($piece);
            $entityManager->flush();
        }

        $type = 'success';
        $message = "Pièce supprimée";
        $this->addFlash($type, $message);
        return $this->redirectToRoute('app_piece_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/ajax/test', name: 'app_piece_ajax', methods: ['GET'])]
    public function getPieceAjax(PieceRepository $pieceRepository, Request $req): Response
    {
        $data = $pieceRepository->findPiecesByIdNotIn($req->query->get("pieces"));
        // dump($data);
        return $this->json(['pieces' => $data]);
    }
}
