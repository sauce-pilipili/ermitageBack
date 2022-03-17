<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="app_articles_index", methods={"GET"})
     */
    public function indexarticles(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('articles/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="app_articles_new", methods={"GET", "POST"})
     */
    public function newarticles($id,Request $request, ArticlesRepository $articlesRepository,CategoriesRepository $categoriesRepository): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('imageEnAvant')->getData() != null) {
                $image = $form->get('imageEnAvant')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $article->setImageEnAvant($fichier);
            }
            $article->setCreatedDate(new \DateTime('now'));
            $article->setCategorie($categoriesRepository->find($id));
            $articlesRepository->add($article);

            return $this->redirectToRoute('app_categories_index');
        }
        return $this->render('articles/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_articles_show", methods={"GET"})
     */
    public function showarticles(Articles $article): Response
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_articles_edit", methods={"GET", "POST"})
     */
    public function editarticles(Request $request, Articles $article, ArticlesRepository $articlesRepository,CategoriesRepository $categoriesRepository): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('imageEnAvant')->getData() != null) {
                $image = $form->get('imageEnAvant')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $article->setImageEnAvant($fichier);
            }
            $articlesRepository->add($article);
            return $this->redirectToRoute('app_categories_index');
        }

        return $this->renderForm('articles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_articles_delete", methods={"POST"})
     */
    public function deletearticles(Request $request, Articles $article, ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articlesRepository->remove($article);
        }

        return $this->redirectToRoute('app_categories_index');
    }












//
//
//
//    /**
//     * @Route("/", name="articles_index", methods={"GET"})
//     */
//    public function index(Request $request, ArticlesRepository $articlesRepository): Response
//    {
//        if ($request->isXmlHttpRequest()) {
//            $titre = $request->get('text');
//            $articles = $articlesRepository->findajaxArticles($titre);
//            return new JsonResponse([
//                'content' => $this->renderView('articles/_contentArticles.html.twig', compact('articles'))
//            ]);
//        }
//        return $this->render('articles/index.html.twig', [
//            'articles' => $articlesRepository->findAll(),
//        ]);
//    }
//
//    /**
//     * @Route("/new", name="articles_new", methods={"GET","POST"})
//     */
//    public function new(Request $request): Response
//    {
//        $article = new Articles();
//        $form = $this->createForm(ArticlesType::class, $article);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $article->setCreatedDate(new \DateTime('now'));
////            gestion image de mise en avant
//            if ($form->get('imageEnAvant')->getData() != null) {
//                $image = $form->get('imageEnAvant')->getData();
//                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
//                $image->move(
//                    $this->getParameter('images_directory'),
//                    $fichier
//                );
//
//                $img = new Photos();
//                $img->setname($fichier);
//                $article->setImageEnAvant($img);
//            }
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($article);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('articles_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->renderForm('articles/new.html.twig', [
//            'article' => $article,
//            'form' => $form,
//        ]);
//    }
//
//    /**
//     * @Route("/{id}", name="articles_show", methods={"GET"})
//     */
//    public function show(Articles $article): Response
//    {
//        return $this->render('articles/show.html.twig', [
//            'article' => $article,
//        ]);
//    }
//
//    /**
//     * @Route("/{id}/edit", name="articles_edit", methods={"GET","POST"})
//     */
//    public function edit(Request $request, Articles $article): Response
//    {
//        $form = $this->createForm(ArticlesType::class, $article);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            if ($form->get('imageEnAvant')->getData() != null) {
//                if ($article->getImageEnAvant()->getName() != null) {
//                    $nom = $article->getImageEnAvant()->getName();
//                    unlink($this->getParameter('images_directory') . '/' . $nom);
//                }
//                $image = $form->get('imageEnAvant')->getData();
//                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
//                $image->move(
//                    $this->getParameter('images_directory'),
//                    $fichier
//                );
//                $img = new Photos();
//                $img->setName($fichier);
//                $article->setImageEnAvant($img);
//
//            }
//            $this->getDoctrine()->getManager()->flush();
//            return $this->redirectToRoute('articles_index', [], Response::HTTP_SEE_OTHER);
//        }
//        return $this->renderForm('articles/edit.html.twig', [
//            'article' => $article,
//            'form' => $form,
//        ]);
//    }
//
//    /**
//     * @Route("/articles/supprime/photo/{id}", name="articles_delete_image", methods={"DELETE"})
//     */
//    public function deleteImage(Photos $image, Request $request)
//    {
//        $data = json_decode($request->getContent(), true);
//        // On vérifie si le token est valide
//        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])) {
//            // On récupère le nom de l'image
//            $nomImageASupprimer = $image->getName();
//            // On supprime le fichier
//            unlink($this->getParameter('images_directory') . '/' . $nomImageASupprimer);
//            // On supprime l'entrée de la base
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($image);
//            $em->flush();
//
//            // On répond en json
//            return new JsonResponse(['success' => 1]);
//        } else {
//            return new JsonResponse(['error' => 'Token Invalide'], 400);
//        }
//    }
//
//
//    /**
//     * @Route("/{id}", name="articles_delete", methods={"POST"})
//     */
//    public function delete(Request $request, Articles $article): Response
//    {
//        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
//            if ($article->getImageEnAvant()!=null){
////                unlink($this->getParameter('images_directory') . '/' . $article->getImageEnAvant());
//            }
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($article);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('articles_index', [], Response::HTTP_SEE_OTHER);
//    }
}