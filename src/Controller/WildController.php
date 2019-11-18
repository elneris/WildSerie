<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WildController
 * @package App\Controller
 * @Route("/wild", name="wild_")
 */
class WildController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('wild/index.html.twig', [
            'website' => 'Wild Série',
        ]);
    }

    /**
     * @Route("/show/{slug}", requirements={"slug"="^[a-z0-9]+(?:-[a-z0-9]+)*$"}, name="show", methods={"GET"})
     * @param string $slug
     * @return Response
     */
    public function show(string $slug = null): Response
    {
        return $this->render('wild/show.html.twig', [
            'slug' => ucwords(str_replace('-',' ', $slug)) ? : 'Aucune série sélectionnée, veuillez choisir une série'
        ]);
    }
}
