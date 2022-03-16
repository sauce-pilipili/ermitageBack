<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Form\ArticlesType;
use App\Form\CategoriesType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function accueil(): Response
    {
        return $this->render('admin/index.html.twig', [

        ]);
    }

    /**
     * @Route("/categories", name="app_categories_index", methods={"GET", "POST"})
     */
    public function index(Request $request, CategoriesRepository $categoriesRepository,ArticlesRepository $articlesRepository): Response
    {
        return $this->render('categories/index.html.twig', [
            'articles'=>$articlesRepository->findAll(),
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/categories/new", name="app_categories_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CategoriesRepository $categoriesRepository, ArticlesRepository $articlesRepository): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setName($request->get('categories')['name']);
            $category->setParent($categoriesRepository->find($request->get('categories')['parent']));
            $categoriesRepository->add($category);

            return new JsonResponse([
                'content' => $this->renderView('categories/_contentCategories.html.twig', [
                    'form'=>$form->createView(),
                    'articles'=>$articlesRepository->findAll(),
                    'categories' => $categoriesRepository->findAll()
                ])
            ]);
        }
        return new JsonResponse(['content' => $this->renderView('categories/new.html.twig', [
            'form' => $form->createView(),
            'articles'=>$articlesRepository->findAll(),
            'categorie' => $category
        ])]);

    }

    /**
     * @Route("/categories/edit/{id}", name="app_categories_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Categories $category, CategoriesRepository $categoriesRepository,ArticlesRepository $articlesRepository): Response
    {
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setName($request->get('categories')['name']);
            $category->setParent($categoriesRepository->find($request->get('categories')['parent']));
            $categoriesRepository->add($category);

            return new JsonResponse([
                'content' => $this->renderView('categories/_contentCategories.html.twig', [
                    'articles'=>$articlesRepository->findAll(),
                    'categories' => $categoriesRepository->findAll()
                ])
            ]);
        }

        return new JsonResponse(['content' => $this->renderView('categories/edit.html.twig', [
            'form' => $form->createView(),

            'articles'=>$articlesRepository->findAll(),
            'categorie' => $category
        ])]);
    }

    /**
     * @Route("/categories/delete/{id}", name="app_categories_delete", methods={"POST"})
     */
    public function delete(Request $request, Categories $category, CategoriesRepository $categoriesRepository,ArticlesRepository $articlesRepository): Response
    {
        $categoriesRepository->remove($category);
        return new JsonResponse([
            'content' => $this->renderView('categories/_contentCategories.html.twig', [
                'articles'=>$articlesRepository->findAll(),
                'categories' => $categoriesRepository->findAll()
            ])
        ]);
    }


//    ****************************************************************************************************************


}
