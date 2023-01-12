<?php

namespace App\Controller;

use App\Form\EditPhotoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * Contrôleur de la page de modification de la photo de profil
     */
    #[Route('/changer-photo-de-profil/', name: 'main_edit_photo')]
    #[IsGranted('ROLE_USER')]
    public function editPhoto(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(EditPhotoType::class);

        $form->handleRequest($request);

        //si le fomulaire a été envoyer et sans erreur

        if($form->isSubmitted() && $form->isValid()){

            $photo = $form->get('photo')->getData();

            $newFileName = 'user' . $this->getUser()->getId() . '.' .$photo->guessExtension();

            $this->getUser()->setPhoto($newFileName);
            $em = $doctrine->getManager();
            $em->flush();

            $photo->move(
                $this->getParameter('app.user.photo.directory'),
                $newFileName
            );

            $this->addFlash('success', 'Photo de profil modifiée avec succès !');

            return $this->redirectToRoute('main_profil');
        }

        return $this->render('main/edit_photo.html.twig',[
            'form' => $form->createView(),
        ]);
    }

}
