<?php

namespace App\Test\Controller;

use App\Entity\Realisation;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RealisationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/realisation/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Realisation::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Realisation index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'realisation[date]' => 'Testing',
            'realisation[temps_reel]' => 'Testing',
            'realisation[poste_id_reel]' => 'Testing',
            'realisation[machine_id_reel]' => 'Testing',
            'realisation[piece]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Realisation();
        $fixture->setDate('My Title');
        $fixture->setTemps_reel('My Title');
        $fixture->setPoste_id_reel('My Title');
        $fixture->setMachine_id_reel('My Title');
        $fixture->setPiece('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Realisation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Realisation();
        $fixture->setDate('Value');
        $fixture->setTemps_reel('Value');
        $fixture->setPoste_id_reel('Value');
        $fixture->setMachine_id_reel('Value');
        $fixture->setPiece('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Enregistrer', [
            'realisation[date]' => 'Something New',
            'realisation[temps_reel]' => 'Something New',
            'realisation[poste_id_reel]' => 'Something New',
            'realisation[machine_id_reel]' => 'Something New',
            'realisation[piece]' => 'Something New',
        ]);

        self::assertResponseRedirects('/realisation/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getTemps_reel());
        self::assertSame('Something New', $fixture[0]->getPoste_id_reel());
        self::assertSame('Something New', $fixture[0]->getMachine_id_reel());
        self::assertSame('Something New', $fixture[0]->getPiece());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Realisation();
        $fixture->setDate('Value');
        $fixture->setTemps_reel('Value');
        $fixture->setPoste_id_reel('Value');
        $fixture->setMachine_id_reel('Value');
        $fixture->setPiece('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/realisation/');
        self::assertSame(0, $this->repository->count([]));
    }
}
