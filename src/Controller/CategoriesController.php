<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categories")
 */
class CategoriesController extends AbstractController
{

    /**
     * @Route("/", name="app_categories_index", methods={"GET", "POST"})
     */
    public function index(Request $request, CategoriesRepository $categoriesRepository, ArticlesRepository $articlesRepository): Response
    {
        return $this->render('categories/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_categories_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CategoriesRepository $categoriesRepository, ArticlesRepository $articlesRepository): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setName($form['name']->getData());
            if ($form['parent']->getData()) {
                $category->setParent($categoriesRepository->find($form['parent']->getData()));
            }
            $categoriesRepository->add($category);

            return new JsonResponse([
                'content' => $this->renderView('categories/_contentCategories.html.twig', [
                    'form' => $form->createView(),
                    'articles' => $articlesRepository->findAll(),
                    'categories' => $categoriesRepository->findAll()
                ])
            ]);
        }
        return new JsonResponse(['content' => $this->renderView('categories/new.html.twig', [
            'form' => $form->createView(),
            'articles' => $articlesRepository->findAll(),
            'categorie' => $category
        ])]);

    }

    /**
     * @Route("/edit/{id}", name="app_categories_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Categories $category, CategoriesRepository $categoriesRepository, ArticlesRepository $articlesRepository): Response
    {
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setName($form['name']->getData());
            if ($form['parent']->getData()) {
                $category->setParent($categoriesRepository->find($form['parent']->getData()));
            }
            $categoriesRepository->add($category);

            return new JsonResponse([
                'content' => $this->renderView('categories/_contentCategories.html.twig', [
                    'articles' => $articlesRepository->findAll(),
                    'categories' => $categoriesRepository->findAll()
                ])
            ]);
        }

        return new JsonResponse(['content' => $this->renderView('categories/edit.html.twig', [
            'form' => $form->createView(),
            'articles' => $articlesRepository->findAll(),
            'categorie' => $category
        ])]);
    }

    /**
     * @Route("/delete/{id}", name="app_categories_delete", methods={"POST"})
     */
    public function delete(Request $request, Categories $category, CategoriesRepository $categoriesRepository, ArticlesRepository $articlesRepository): Response
    {
        $categoriesRepository->remove($category);

        return $this->render('categories/index.html.twig', [
                'articles' => $articlesRepository->findAll(),
                'categories' => $categoriesRepository->findAll()
        ]);
    }
}
