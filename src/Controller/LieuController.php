<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class LieuController extends AbstractController
{
    #[Route('/lieu', name: 'app_lieu')]
    #[IsGranted('ROLE_USER')]
    public function index(LieuRepository $lieuRepository): Response
    {
        return $this->render('lieu/index.html.twig', [
            'lieu' => $lieuRepository->findAll(),
        ]);
    }

    #[Route('/lieu/{id}', name: 'app_lieu_show')]
    #[IsGranted('ROLE_USER')]
    public function show(Lieu $lieu): Response
    {
        return $this->render('lieu/show.html.twig', [
            'lieu' => $lieu,
        ]);
    }

    #[Route('/addLieu', name: 'app_lieu_add')]
    #[IsGranted('ROLE_USER')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lieu = new Lieu();

        $form = $this->createForm(LieuType::class, $lieu);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lieu);
            $entityManager->flush();

            return $this->redirectToRoute('app_lieu');
        }

        return $this->render('lieu/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
