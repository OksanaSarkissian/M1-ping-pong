<?php

namespace App\Test\Controller;

use App\Entity\Piece;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PieceControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/piece/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Piece::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Piece index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'piece[reference_piece]' => 'Testing',
            'piece[libelle_piece]' => 'Testing',
            'piece[prix_u]' => 'Testing',
            'piece[stock]' => 'Testing',
            'piece[gamme_id]' => 'Testing',
            'piece[pieces_id]' => 'Testing',
            'piece[qtt_piece]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Piece();
        $fixture->setReference_piece('My Title');
        $fixture->setLibelle_piece('My Title');
        $fixture->setPrix_u('My Title');
        $fixture->setStock('My Title');
        $fixture->setGamme_id('My Title');
        $fixture->setPieces_id('My Title');
        $fixture->setQtt_piece('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Piece');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Piece();
        $fixture->setReference_piece('Value');
        $fixture->setLibelle_piece('Value');
        $fixture->setPrix_u('Value');
        $fixture->setStock('Value');
        $fixture->setGamme_id('Value');
        $fixture->setPieces_id('Value');
        $fixture->setQtt_piece('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'piece[reference_piece]' => 'Something New',
            'piece[libelle_piece]' => 'Something New',
            'piece[prix_u]' => 'Something New',
            'piece[stock]' => 'Something New',
            'piece[gamme_id]' => 'Something New',
            'piece[pieces_id]' => 'Something New',
            'piece[qtt_piece]' => 'Something New',
        ]);

        self::assertResponseRedirects('/piece/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getReference_piece());
        self::assertSame('Something New', $fixture[0]->getLibelle_piece());
        self::assertSame('Something New', $fixture[0]->getPrix_u());
        self::assertSame('Something New', $fixture[0]->getStock());
        self::assertSame('Something New', $fixture[0]->getGamme_id());
        self::assertSame('Something New', $fixture[0]->getPieces_id());
        self::assertSame('Something New', $fixture[0]->getQtt_piece());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Piece();
        $fixture->setReference_piece('Value');
        $fixture->setLibelle_piece('Value');
        $fixture->setPrix_unitaire('Value');
        $fixture->setStock('Value');
        $fixture->setGamme_id('Value');
        $fixture->setPieces_id('Value');
        $fixture->setQtt_piece('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/piece/');
        self::assertSame(0, $this->repository->count([]));
    }
}
