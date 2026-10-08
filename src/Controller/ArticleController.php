<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    #[IsGranted('ROLE_USER')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('article/index.html.twig', [
            'controller_name' => 'Mathéo',
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{id}', name: 'app_article_show')]
    #[IsGranted('ROLE_USER')]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/article2', name: 'app_article2')]
    public function index2(): Response
    {
        $number = random_int(0, 100);
        return $this->render('article/index2.html.twig', [
            'controller_name' => 'ArticleController',
            'number' => $number,
        ]);
    }

    #[route('/addArticle', name: 'app_article_add')]
    #[IsGranted('ROLE_USER')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $article->setAuteur($this->getUser());
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article');
        }

        return $this->render('article/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article/{id}/delete', name: 'app_article_delete', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
                throw $this->createAccessDeniedException();
            }

            $entityManager->remove($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article');
        }

        return $this->render('article/delete.html.twig', [
            'article' => $article,
        ]);
    }
}
