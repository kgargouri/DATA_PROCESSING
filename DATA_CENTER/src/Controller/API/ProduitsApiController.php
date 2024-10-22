<?php

namespace App\Controller\API;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
/*use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;*/

#[Route('/api/produits')]
class ProduitsApiController extends AbstractController
{
    #[Route('/', methods: ["GET"])]
    public function index(ProduitsRepository $repository): Response
    {
        $produits = $repository->findAll();
        return $this->json($produits, 200, [], [
            'groups' => ['produits.index']
        ]);
    }
    
    #[Route('/{id}', methods: ["GET"], requirements: ['id' => Requirement::DIGITS])]
    public function show(Produits $produit): Response
    {
        //dump($produit);
        return $this->json($produit, 200, [], [
            'groups' => ['produits.show']
        ]);
    }

    #[Route('/', methods: ["POST"])]
    public function create(
        Request $request, 
        #[MapRequestPayload(
            serializationContext: ['produit.create']
        )]
        Produits $produit,
        EntityManagerInterface $em
    )
    {
        $em->persist($produit);
        $em->flush();
        return $this->json($produit, 200, [], [
            'groups' => ['produit.index', 'produit.show']
        ]);
    }

    #[Route('/{id}', methods: ["PUT"], requirements: ['id' => Requirement::DIGITS])]
    public function update(
        Request $request, 
        #[MapRequestPayload(
            serializationContext: ['produit.create']
        )]
        Produits $produit,
        EntityManagerInterface $em
    )
    {
        $data = json_decode($request->getContent(), true);
        dump($request);
        dump($produit);die;
        $produit->setNom($data['nom']);
        $em->persist($produit);
        $em->flush();
        return $this->json($produit, 200, [], [
            'groups' => ['produit.index', 'produit.show']
        ]);
    }
}