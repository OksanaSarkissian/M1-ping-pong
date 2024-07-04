<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\LigneDocument;
use App\Form\DocumentType;
use App\Form\CommandeType;
use App\Repository\DocumentRepository;
use App\Repository\LigneDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Serializer\Normalizer\DocumentNormalizer;
use DateTimeImmutable;
use Doctrine\DBAL\Types\DateImmutableType;
use Symfony\Component\Serializer\Serializer;

#[Route('/commerce/document')]
class DocumentController extends AbstractController
{
    #[Route('/devis', name: 'app_devis_index', methods: ['GET'])]
    public function indexDevis(DocumentRepository $documentRepository): Response
    {
        $devis = $documentRepository->findAllByType('devis');

        return $this->render('document/index.html.twig', [
            'documents' => $devis,
            'active' => 'devis',
        ]);
    }

    #[Route('/commandes/csv', name: 'app_commande_csv', methods: ['GET'])]
    public function devisCsv(DocumentRepository $documentRepository): Response
    {
        $devis = $documentRepository->findAllByType('commandes');

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

    #[Route('/commande', name: 'app_commande_index', methods: ['GET'])]
    public function indexCommande(DocumentRepository $documentRepository): Response
    {
        return $this->render('document/index.html.twig', [
            'documents' => $documentRepository->findAllByType('commandes'),
            'active' => 'commandes',
        ]);
    }

    #[Route('/new/{variable}', name: 'app_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, $variable, LigneDocumentRepository $ligneDocumentRepository): Response
    {
        $document = new Document();
        $ligneDocument = new LigneDocument();
        if ($variable == 'commandes') {
            // dump($variable);
            $form = $this->createForm(CommandeType::class, $document);
        } else {
            $form = $this->createForm(DocumentType::class, $document);
        }
        $form->handleRequest($request);
        $document->setType($variable);
        // dump($document);
        // dump($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $montantTotal = 0;
            foreach ($document->getLigneDocument() as $ligneDocument) {
                $montantTotal += $ligneDocument->getPrixVente() * $ligneDocument->getQuantite();
                $entityManager->persist($ligneDocument);
            }
            $document->setMontantTotal($montantTotal);
            // dump($document);
            $entityManager->persist($document);
            $entityManager->flush();
            // $type peut être : success, warning, danger, etc.
            // $message : Contient le contenu de la notification 
            $type = 'success';
            $message = ucfirst($variable) . " créé" . ($variable == 'commande' ? 'e' : '');
            $this->addFlash($type, $message);
            return $this->redirectToRoute($variable == 'commandes' ? 'app_commande_index' : 'app_devis_index', [], Response::HTTP_SEE_OTHER);
        }
        if ($form->isSubmitted()) {
            $this->addFlash(
                'danger',
                'Il y a eu un problème, vérifiez le formulaire. Si le problème persiste contactez le support!'
            );
            exit;
        }

        return $this->render('document/new.html.twig', [
            'document' => $document,
            'form' => $form,
            'formType' => 'new',
            'documentType' => $variable,
        ]);
    }

    #[Route('/{id}/{variable}', name: 'app_document_show', methods: ['GET'])]
    public function show(Document $document, $variable): Response
    {
        return $this->render('document/show.html.twig', [
            'document' => $document,
            'documentType' => $variable,
        ]);
    }

    #[Route('/{id}/edit/{variable}', name: 'app_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Document $document, EntityManagerInterface $entityManager, $variable): Response
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $montantTotal = 0;
            foreach ($document->getLigneDocument() as $ligneDocument) {
                $montantTotal += $ligneDocument->getPrixVente() * $ligneDocument->getQuantite();
                $entityManager->persist($ligneDocument);
            }
            $document->setMontantTotal($montantTotal);
            $entityManager->flush();

            $type = 'success';
            $message = ucfirst($variable) . " modifié" . ($variable == 'commande' ? 'e' : '');
            $this->addFlash($type, $message);
            return $this->redirectToRoute('app_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('document/edit.html.twig', [
            'document' => $document,
            'form' => $form,
            'formType' => 'edit',
            'documentType' => $variable,
        ]);
    }

    #[Route('/{id}', name: 'app_document_delete', methods: ['POST'])]
    public function delete(Request $request, Document $document, EntityManagerInterface $entityManager, $variable): Response
    {
        if ($this->isCsrfTokenValid('delete' . $document->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($document);
            $entityManager->flush();
        }

        $type = 'success';
        $message = ucfirst($variable) . " supprimé" . ($variable == 'commande' ? 'e' : '');
        $this->addFlash($type, $message);
        return $this->redirectToRoute('app_devis_index', [], Response::HTTP_SEE_OTHER);
    }
}
