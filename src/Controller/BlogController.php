<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\CreateArticleFormType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * préfixe de la route et du nom de toutes les pages de la partie blog du site
 */
#[Route('/blog', name: 'blog_')]
class BlogController extends AbstractController
{
    /**
     * Contrôleur de la page permettant de créer un nouvel article
     */
    #[Route('/nouvelle-publication/', name: 'new_publication')]
    #[IsGranted('ROLE_ADMIN')]
    public function newPublication(Request $request, ManagerRegistry $doctrine): Response
    {

        // Création d'un nouvel article vide
        $newArticle = new Article();

        // Création d'un formulaire de création d'article, lié à l'article vide
        $form = $this->createForm(CreateArticleFormType::class, $newArticle);

        // Liaison des données POST aux formulaires
        $form->handleRequest($request);

        // Si le formulaire a bien été envoyé et sans erreurs
        if($form->isSubmitted() && $form->isValid()){


            // Hydrater l'article
            $newArticle
                ->setPublicationDate( new \DateTime() )     // Date actuelle
                ->setAuthor( $this->getUser() )       // Auteur de l'article (la personne actuellement connectée)
            ;

            // Sauvegarde de l'article en BDD
            $em = $doctrine->getManager();
            $em->persist( $newArticle );
            $em->flush();

            // Message de succès
            $this->addFlash('success', 'Article publié avec succès !');

            return $this->redirectToRoute('main_home');

        }

        return $this->render('blog/new_publication.html.twig', [
            'CreateArticleFormType' => $form->createView(),
        ]);
    }


    /**
     * Contrôleur de la page qui liste tous les articles
     */

    #[Route('/publications/liste', name: 'publication_list' )]
    public function publicationList(ManagerRegistry $doctrine): Response
    {

        $articleRepo = $doctrine->getRepository( Article::class );

        $articles = $articleRepo->findAll();

       

        return $this->render('blog/new_publication_list.html.twig', [
            'articles' => $articles,
        ]);
    }
}

