<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
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
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }

        return $this->render(
            'wild/index.html.twig',
            ['programs' => $programs]
        );
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show")
     * @return Response
     */
    public function show(?string $slug):Response
    {
        $program = null;
        if ($slug) {
            $slug = str_replace('-', ' ', ucwords(trim(strip_tags($slug)), '-'));
            $program = $this->getDoctrine()
                ->getRepository(Program::class)
                ->findOneBy(['title' => mb_strtolower($slug)]);
        }


        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug'  => $slug ? : 'Aucune série sélectionnée, veuillez choisir une série'
        ]);
    }

    /**
     * Getting a program with a formatted slug for category
     *
     * @param string|null $categoryName
     * @return Response
     * @Route("/category/{categoryName}", defaults={"categoryName" = null}, name="category")
     */
    public function showByCategory(?string $categoryName):Response
    {
        $category = null;
        $movies = null;

        if ($categoryName) {
            $category = $this->getDoctrine()
                ->getRepository(Category::class)
                ->findOneBy(['name' => $categoryName]);
        }

        if ($category) {
            $movies = $this->getDoctrine()
                ->getRepository(Program::class)
                ->findBy(['category' => $category],['id' => 'DESC'], 3);
        }


        return $this->render('wild/category.html.twig', [
            'category' => $category,
            'movies'  => $movies,
            'categoryName' => $categoryName
        ]);
    }
}
