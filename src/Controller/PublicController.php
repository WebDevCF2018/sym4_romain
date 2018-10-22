<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
// use entity Sections.php
use App\Entity\Sections;
// use entity Articles.php
use App\Entity\Articles;

class PublicController extends AbstractController
{
    /**
     *
     * Matches / exactly to view homepage
     *
     * @Route("/", name="accueil")
     */
    public function index()
    {
        // get Doctrine Manager for all entities
        $entityManager = $this->getDoctrine()->getManager();

        // get all sections in db for menu
        $rub = $entityManager->getRepository(Sections::class)->findAll();

        // get all articles from db ORDER BY idarticles DESC
        $art = $entityManager->getRepository(Articles::class)->findBy([],["idarticles"=>"DESC"]);

        // return the Twig's view with 2 arguments
        return $this->render('public/index.html.twig', [
            'sections' => $rub,
            'articles' => $art,
        ]);
    }
    /**
     *
     * Matches /article/{id},
     * {id} is a requirement digit: "\d+" for more security
     * to view an article's detail
     *
     * @Route("/article/{id}", name="detail_article", requirements={"id"="\d+"})
     */
    public function oneArticle($id){
        // get Doctrine Manager for all entities
        $entityManager = $this->getDoctrine()->getManager();

        // get all sections in db for menu
        $rub = $entityManager->getRepository(Sections::class)->findAll();

        // get one article by its "id" from db
        $art = $entityManager->getRepository(Articles::class)->find($id);

        // return the Twig's view with 2 arguments
        return $this->render('public/one_article.html.twig', [
            'sections' => $rub,
            'articles' => $art,
        ]);
    }
    /**
     *
     * Matches /section/{id},
     * {id} is a requirement digit: "\d+" for more security
     * to view an section's detail
     *
     * @Route("/section/{id}", name="detail_section", requirements={"id"="\d+"})
     */
    public function oneSection($id){
        // get Doctrine Manager for all entities
        $entityManager = $this->getDoctrine()->getManager();

        // get all sections in db for menu
        $rub = $entityManager->getRepository(Sections::class)->findAll();

        // get one section by its "id" from db
        $section = $entityManager->getRepository(Sections::class)->find($id);

        // get all articles by one section, it's the easy way, you can use ORDER BY into sections.php entity, views annotation before private $articlesarticles;
        $art = $section->getArticlesarticles();



        // return the Twig's view with 2 arguments
        return $this->render('public/one_section.html.twig', [
            'sections' => $rub,
            'section' => $section,
            'articles' => $art,
        ]);
    }
}
