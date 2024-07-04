<?php

namespace App\Test\Controller;

use App\Entity\Operation;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OperationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/operation/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Operation::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Operation index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'operation[libelle]' => 'Testing',
            'operation[description]' => 'Testing',
            'operation[temps]' => 'Testing',
            'operation[poste_id]' => 'Testing',
            'operation[machine_id]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Operation();
        $fixture->setLibelle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setTemps('My Title');
        $fixture->setPoste_id('My Title');
        $fixture->setMachine_id('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Operation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Operation();
        $fixture->setLibelle('Value');
        $fixture->setDescription('Value');
        $fixture->setTemps('Value');
        $fixture->setPoste_id('Value');
        $fixture->setMachine_id('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Enregistrer', [
            'operation[libelle]' => 'Something New',
            'operation[description]' => 'Something New',
            'operation[temps]' => 'Something New',
            'operation[poste_id]' => 'Something New',
            'operation[machine_id]' => 'Something New',
        ]);

        self::assertResponseRedirects('/operation/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getLibelle());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getTemps());
        self::assertSame('Something New', $fixture[0]->getPoste_id());
        self::assertSame('Something New', $fixture[0]->getMachine_id());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Operation();
        $fixture->setLibelle('Value');
        $fixture->setDescription('Value');
        $fixture->setTemps('Value');
        $fixture->setPoste_id('Value');
        $fixture->setMachine_id('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/operation/');
        self::assertSame(0, $this->repository->count([]));
    }
}
