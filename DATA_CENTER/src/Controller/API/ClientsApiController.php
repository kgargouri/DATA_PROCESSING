<?php

namespace App\Controller\API;

use App\Entity\Clients;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
/*use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;*/

#[Route('/api/clients')]
class ClientsApiController extends AbstractController
{
    #[Route('/', methods: ["GET"])]
    public function index(ClientsRepository $repository): Response
    {
        $clients = $repository->findAll();
        return $this->json($clients, 200, [], [
            'groups' => ['clients.index']
        ]);
    }
    
    #[Route('/{id}', methods: ["GET"], requirements: ['id' => Requirement::DIGITS])]
    public function show(Clients $client): Response
    {
        //dump($client);
        return $this->json($client, 200, [], [
            'groups' => ['clients.show']
        ]);
    }
}