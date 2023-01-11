<?php

namespace App\Controller;

use App\Generator\RandomMD5Hash;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{

    #[Route('/', name: 'main_home')]
    public function home(): Response
    {
        return $this->render('main/home.html.twig');

    }

    /**
     * contrôller de la page mon profile
     */
    #[Route('/mon-profil/', name: 'main_profil')]
    #[IsGranted('ROLE_USER')]
    public function profil(): Response
    {

        return $this->render('main/profil.html.twig');
    }
}
