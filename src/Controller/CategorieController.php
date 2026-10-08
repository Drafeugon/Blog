<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieControllerType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    #[IsGranted('ROLE_USER')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/categorie/{id}', name: 'app_categorie_show')]
    #[IsGranted('ROLE_USER')]
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/addCategorie', name: 'app_categorie_add')]
    #[IsGranted('ROLE_USER')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieControllerType::class, $categorie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie');
        }

        return $this->render('categorie/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
