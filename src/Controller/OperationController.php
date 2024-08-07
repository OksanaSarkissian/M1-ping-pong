<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Form\OperationType;
use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Realisation;
use App\Form\RealisationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/atelier/operation')]
class OperationController extends AbstractController
{
    #[Route('/', name: 'app_operation_index', methods: ['GET'])]
    public function index(OperationRepository $operationRepository): Response
    {
        return $this->render('operation/index.html.twig', [
            'operations' => $operationRepository->findAll(),
            'active' => 'operation',
        ]);
    }

    #[Route('/respo/new', name: 'app_operation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $operation = new Operation();
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($operation);
            $entityManager->flush();

            $type = 'success';
            $message = "Opération créée";
            $this->addFlash($type, $message);
            return $this->redirectToRoute('app_operation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('operation/new.html.twig', [
            'operation' => $operation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_operation_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Operation $operation, EntityManagerInterface $entityManager,Security $security): Response
    {
        $realisation = new Realisation($security);
        $form = $this->createForm(RealisationType::class, $realisation, array('operation'=>$operation));
        $form->handleRequest($request);

        // dump($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($realisation);
            $entityManager->flush();

            $type = 'success';
            $message = "Opération réalisée";
            $this->addFlash($type, $message);
            return $this->redirectToRoute('app_realisation_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('operation/show.html.twig', [
            'operation' => $operation,
            'form' => $form
        ]);
    }

    #[Route('/respo/{id}/edit', name: 'app_operation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Operation $operation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $type = 'success';
            $message = "Opération modifiée";
            $this->addFlash($type, $message);
            return $this->redirectToRoute('app_operation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('operation/edit.html.twig', [
            'operation' => $operation,
            'form' => $form,
        ]);
    }

    #[Route('/respo/{id}', name: 'app_operation_delete', methods: ['POST'])]
    public function delete(Request $request, Operation $operation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $operation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($operation);
            $entityManager->flush();
        }

        $type = 'success';
            $message = "Opération supprimée";
            $this->addFlash($type, $message);

        return $this->redirectToRoute('app_operation_index', [], Response::HTTP_SEE_OTHER);
    }
}
