<?php

namespace App\Services;

use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategorieServices{

    public function __construct(EntityManagerInterface $em,
                                Environment $environnement,
                                ParameterBagInterface $parameterBag)
    {}





}