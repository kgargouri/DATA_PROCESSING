<?php

namespace App\Tests\Controller;

use App\Entity\Produits;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ProduitsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/produits/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Produits::class);

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
        self::assertPageTitleContains('Produit index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'produit[nom]' => 'Testing',
            'produit[categorie]' => 'Testing',
            'produit[sous_categorie]' => 'Testing',
            'produit[cout_unitaire]' => 'Testing',
            'produit[prix_unitaire]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produits();
        $fixture->setNom('My Title');
        $fixture->setCategorie('My Title');
        $fixture->setSous_categorie('My Title');
        $fixture->setCout_unitaire('My Title');
        $fixture->setPrix_unitaire('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Produit');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produits();
        $fixture->setNom('Value');
        $fixture->setCategorie('Value');
        $fixture->setSous_categorie('Value');
        $fixture->setCout_unitaire('Value');
        $fixture->setPrix_unitaire('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'produit[nom]' => 'Something New',
            'produit[categorie]' => 'Something New',
            'produit[sous_categorie]' => 'Something New',
            'produit[cout_unitaire]' => 'Something New',
            'produit[prix_unitaire]' => 'Something New',
        ]);

        self::assertResponseRedirects('/produits/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getCategorie());
        self::assertSame('Something New', $fixture[0]->getSous_categorie());
        self::assertSame('Something New', $fixture[0]->getCout_unitaire());
        self::assertSame('Something New', $fixture[0]->getPrix_unitaire());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produits();
        $fixture->setNom('Value');
        $fixture->setCategorie('Value');
        $fixture->setSous_categorie('Value');
        $fixture->setCout_unitaire('Value');
        $fixture->setPrix_unitaire('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/produits/');
        self::assertSame(0, $this->repository->count([]));
    }
}
