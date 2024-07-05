<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\LigneAchat;
use App\Form\AchatType;
use App\Repository\AchatRepository;
use App\Repository\LigneAchatRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Serializer\Normalizer\DocumentNormalizer;
use Doctrine\DBAL\Types\DateImmutableType;
use Symfony\Component\Serializer\Serializer;

#[Route('/commerce/achat')]
class AchatController extends AbstractController
{
    #[Route('/', name: 'app_achat_index', methods: ['GET'])]
    public function index(AchatRepository $achatRepository): Response
    {
        return $this->render('achat/index.html.twig', [
            'achats' => $achatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_achat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, LigneAchatRepository $ligneAchatRepository): Response
    {
        $achat = new Achat();
        $ligneAchat = new LigneAchat();
        $form = $this->createForm(AchatType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $montantTotal = 0;
            foreach ($achat->getLigneAchats() as $ligneAchat) {
                $montantTotal += $ligneAchat->getPrixAchat() * $ligneAchat->getQuantite();
                $entityManager->persist($ligneAchat);
            }
            $achat->setMontantTotal($montantTotal);

            $entityManager->persist($achat);
            $entityManager->flush();

            $type = 'success';
            $message = "Achat créé";
            $this->addFlash($type, $message);
            return $this->redirectToRoute('app_achat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('achat/new.html.twig', [
            'achat' => $achat,
            'form' => $form,
            'formType' => 'new'
        ]);
    }

    #[Route('/{id}', name: 'app_achat_show', methods: ['GET'])]
    public function show(Achat $achat): Response
    {
        return $this->render('achat/show.html.twig', [
            'achat' => $achat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_achat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Achat $achat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AchatType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $type = 'success';
            $message = "Achat modifié";
            $this->addFlash($type, $message);
            return $this->redirectToRoute('app_achat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('achat/edit.html.twig', [
            'achat' => $achat,
            'form' => $form,
            'formType' => 'edit'
        ]);
    }

    #[Route('/{id}', name: 'app_achat_delete', methods: ['POST'])]
    public function delete(Request $request, Achat $achat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $achat->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($achat);
            $entityManager->flush();
        }
        $type = 'success';
        $message = "Achat supprimé";
        $this->addFlash($type, $message);
        return $this->redirectToRoute('app_achat_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/achats/csv', name: 'app_achat_csv', methods: ['GET'])]
    public function achatsCsv(AchatRepository $achatRepository): Response
    {
        $devis = $achatRepository->findAll();
        ob_start();
        $df = fopen("php://output", "w");
        // fputcsv($df, );
        fputcsv($df, array_keys($devis));
        array_map(function ($devisItem) use ($df) {
            fputcsv($df, [$devisItem->getDate()->format("d-m-Y"), $devisItem->getMontantTotal() . '€']);
        }, $devis);
        $response = new Response(stream_get_contents($df));
        fclose($df);

        $date = new DateTimeImmutable();

        $response->headers->set('Content-Encoding', 'UTF-8');
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename=commandes ' .  $date->format("d-m-Y h_i_s") . '.csv');
        return $response;
    }
}
