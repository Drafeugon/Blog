<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'app_evenement')]
    public function index(): Response
    {
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }

    #[Route('/evenement/{id}', name: 'app_evenement_show')]
    #[IsGranted('ROLE_USER')]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[route('/addEvenement', name: 'app_evenement_add')]
    #[IsGranted('ROLE_USER')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();

        $form = $this->createForm(EvenementType::class, $evenement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evenement = $form->getData();
            $evenement->setCreateur($this->getUser());
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement');
        }

        return $this->render('evenement/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/evenement/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Evenement $evenement, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement');
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/evenement/{id}/delete', name: 'app_evenement_delete', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Evenement $evenement, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('delete' . $evenement->getId(), $request->request->get('_token'))) {
                throw $this->createAccessDeniedException();
            }

            $entityManager->remove($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement');
        }

        return $this->render('evnement/delete.html.twig', [
            'evenement' => $evenement,
        ]);
    }
}
