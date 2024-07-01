<?php

namespace App\Test\Controller;

use App\Entity\Document;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DocumentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/document/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Document::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Document index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'document[date]' => 'Testing',
            'document[type]' => 'Testing',
            'document[montant_total]' => 'Testing',
            'document[delai]' => 'Testing',
            'document[document]' => 'Testing',
            'document[documents]' => 'Testing',
            'document[client]' => 'Testing',
            'document[ligne_document]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Document();
        $fixture->setDate('My Title');
        $fixture->setType('My Title');
        $fixture->setMontant_total('My Title');
        $fixture->setDelai('My Title');
        $fixture->setDocument('My Title');
        $fixture->setDocuments('My Title');
        $fixture->setClient('My Title');
        $fixture->setLigne_document('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Document');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Document();
        $fixture->setDate('Value');
        $fixture->setType('Value');
        $fixture->setMontant_total('Value');
        $fixture->setDelai('Value');
        $fixture->setDocument('Value');
        $fixture->setDocuments('Value');
        $fixture->setClient('Value');
        $fixture->setLigne_document('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'document[date]' => 'Something New',
            'document[type]' => 'Something New',
            'document[montant_total]' => 'Something New',
            'document[delai]' => 'Something New',
            'document[document]' => 'Something New',
            'document[documents]' => 'Something New',
            'document[client]' => 'Something New',
            'document[ligne_document]' => 'Something New',
        ]);

        self::assertResponseRedirects('/document/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getMontant_total());
        self::assertSame('Something New', $fixture[0]->getDelai());
        self::assertSame('Something New', $fixture[0]->getDocument());
        self::assertSame('Something New', $fixture[0]->getDocuments());
        self::assertSame('Something New', $fixture[0]->getClient());
        self::assertSame('Something New', $fixture[0]->getLigne_document());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Document();
        $fixture->setDate('Value');
        $fixture->setType('Value');
        $fixture->setMontant_total('Value');
        $fixture->setDelai('Value');
        $fixture->setDocument('Value');
        $fixture->setDocuments('Value');
        $fixture->setClient('Value');
        $fixture->setLigne_document('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/document/');
        self::assertSame(0, $this->repository->count([]));
    }
}
