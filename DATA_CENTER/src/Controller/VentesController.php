<?php

namespace App\Controller;

use App\Entity\Ventes;
use App\Form\VentesType;
use App\Repository\VentesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/ventes')]
final class VentesController extends AbstractController
{
    #[Route(name: 'app_ventes_index', methods: ['GET'])]
    public function index(VentesRepository $ventesRepository): Response
    {
        return $this->render('ventes/index.html.twig', [
            'ventes' => $ventesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ventes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vente = new Ventes();
        $form = $this->createForm(VentesType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vente);
            $entityManager->flush();

            return $this->redirectToRoute('app_ventes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ventes/new.html.twig', [
            'vente' => $vente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ventes_show', methods: ['GET'])]
    public function show(Ventes $vente): Response
    {
        return $this->render('ventes/show.html.twig', [
            'vente' => $vente,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ventes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ventes $vente, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VentesType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ventes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ventes/edit.html.twig', [
            'vente' => $vente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ventes_delete', methods: ['POST'])]
    public function delete(Request $request, Ventes $vente, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vente->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($vente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ventes_index', [], Response::HTTP_SEE_OTHER);
    }
}
