<?php

namespace App\Tests\Controller;

use App\Entity\Ventes;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class VentesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/ventes/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Ventes::class);

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
        self::assertPageTitleContains('Vente index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'vente[n_commande]' => 'Testing',
            'vente[date_commande]' => 'Testing',
            'vente[canal]' => 'Testing',
            'vente[quantite]' => 'Testing',
            'vente[date_livraison]' => 'Testing',
            'vente[client]' => 'Testing',
            'vente[produit]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ventes();
        $fixture->setN_commande('My Title');
        $fixture->setDate_commande('My Title');
        $fixture->setCanal('My Title');
        $fixture->setQuantite('My Title');
        $fixture->setDate_livraison('My Title');
        $fixture->setClient('My Title');
        $fixture->setProduit('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Vente');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ventes();
        $fixture->setN_commande('Value');
        $fixture->setDate_commande('Value');
        $fixture->setCanal('Value');
        $fixture->setQuantite('Value');
        $fixture->setDate_livraison('Value');
        $fixture->setClient('Value');
        $fixture->setProduit('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'vente[n_commande]' => 'Something New',
            'vente[date_commande]' => 'Something New',
            'vente[canal]' => 'Something New',
            'vente[quantite]' => 'Something New',
            'vente[date_livraison]' => 'Something New',
            'vente[client]' => 'Something New',
            'vente[produit]' => 'Something New',
        ]);

        self::assertResponseRedirects('/ventes/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getN_commande());
        self::assertSame('Something New', $fixture[0]->getDate_commande());
        self::assertSame('Something New', $fixture[0]->getCanal());
        self::assertSame('Something New', $fixture[0]->getQuantite());
        self::assertSame('Something New', $fixture[0]->getDate_livraison());
        self::assertSame('Something New', $fixture[0]->getClient());
        self::assertSame('Something New', $fixture[0]->getProduit());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ventes();
        $fixture->setN_commande('Value');
        $fixture->setDate_commande('Value');
        $fixture->setCanal('Value');
        $fixture->setQuantite('Value');
        $fixture->setDate_livraison('Value');
        $fixture->setClient('Value');
        $fixture->setProduit('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/ventes/');
        self::assertSame(0, $this->repository->count([]));
    }
}
