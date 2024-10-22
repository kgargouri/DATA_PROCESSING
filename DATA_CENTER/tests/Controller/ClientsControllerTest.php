<?php

namespace App\Tests\Controller;

use App\Entity\Clients;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ClientsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/clients/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Clients::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Client index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'client[client]' => 'Testing',
            'client[adresse]' => 'Testing',
            'client[code_postal]' => 'Testing',
            'client[ville]' => 'Testing',
            'client[telephone]' => 'Testing',
            'client[civilite]' => 'Testing',
            'client[prenom]' => 'Testing',
            'client[nom]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Clients();
        $fixture->setClient('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCode_postal('My Title');
        $fixture->setVille('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setCivilite('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setNom('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Client');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Clients();
        $fixture->setClient('Value');
        $fixture->setAdresse('Value');
        $fixture->setCode_postal('Value');
        $fixture->setVille('Value');
        $fixture->setTelephone('Value');
        $fixture->setCivilite('Value');
        $fixture->setPrenom('Value');
        $fixture->setNom('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'client[client]' => 'Something New',
            'client[adresse]' => 'Something New',
            'client[code_postal]' => 'Something New',
            'client[ville]' => 'Something New',
            'client[telephone]' => 'Something New',
            'client[civilite]' => 'Something New',
            'client[prenom]' => 'Something New',
            'client[nom]' => 'Something New',
        ]);

        self::assertResponseRedirects('/clients/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getClient());
        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getCode_postal());
        self::assertSame('Something New', $fixture[0]->getVille());
        self::assertSame('Something New', $fixture[0]->getTelephone());
        self::assertSame('Something New', $fixture[0]->getCivilite());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getNom());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Clients();
        $fixture->setClient('Value');
        $fixture->setAdresse('Value');
        $fixture->setCode_postal('Value');
        $fixture->setVille('Value');
        $fixture->setTelephone('Value');
        $fixture->setCivilite('Value');
        $fixture->setPrenom('Value');
        $fixture->setNom('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/clients/');
        self::assertSame(0, $this->repository->count([]));
    }
}
