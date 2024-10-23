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
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
/*use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;*/
use Symfony\Component\Serializer\SerializerInterface;


class ProduitsApiController extends AbstractController
{
    #[Route('/api/produits', name: 'api_produits_list', methods: ["GET"])]
    public function index(ProduitsRepository $repository): Response
    {
        $produits = $repository->findAll();
        return $this->json($produits, 200, [], [
            'groups' => ['produits.index']
        ]);
    }
    
    #[Route('/api/produits/{id}', name: 'api_produits_show', methods: ["GET"], requirements: ['id' => Requirement::DIGITS])]
    public function show(Produits $produit): Response
    {
        //dump($produit);
        return $this->json($produit, 200, [], [
            'groups' => ['produits.show']
        ]);
    }

    #[Route('/api/produits/{id}', name: 'api_produits_update', methods: ["PUT"], requirements: ['id' => Requirement::DIGITS])]
    public function update(
        Request $request, 
        Produits $produit,
        EntityManagerInterface $em
    )
    {
        
        $produitApi = json_decode($request->getContent(), true);
        $produit->setNom($produitApi['nom']);
        $produit->setCategorie($produitApi['categorie']);
        $produit->setSousCategorie($produitApi['sous_categorie']);
        $produit->setCoutUnitaire($produitApi['cout_unitaire']);
        $produit->setPrixUnitaire($produitApi['prix_unitaire']);
        $em->persist($produit);
        $em->flush();
        return $this->json($produit, 200, [], [
            'groups' => ['produit.create']
        ]);
    }

    #[Route('/api/produits', name: 'api_produits_create', methods: ["POST"])]
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
        $produit->getId();
        return $this->json($produit->getId(), 200, [], [
            'groups' => ['produit.create']
        ]);
    }
}