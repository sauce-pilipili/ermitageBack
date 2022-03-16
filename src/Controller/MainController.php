<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [

        ]);
    }

    /**
     * @Route("/actualite/{categorie}", name="actualite")
     */
    public function actualite(Request $request, $categorie="tout"): Response
    {

        return $this->render('main/actualite.html.twig', [

        ]);
    }

    /**
     * @Route("/article/{slug}", name="actualite")
     */
    public function article(Request $request, $slug=null): Response
    {

        return $this->render('main/article.html.twig', [

        ]);
    }
//************************************************PAGE STATIQUE********************************************


    /**
     * @Route("/work-cafe", name="workCafe")
     */
    public function workCafe(): Response
    {
        return $this->render('main/workCafe.html.twig', [

        ]);
    }
}
