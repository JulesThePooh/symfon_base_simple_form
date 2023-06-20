<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{

    public function __construct(
        //use Doctrine\ORM\EntityManagerInterface;
        private EntityManagerInterface $entityManager
    )
    {

    }

    #[Route('/add_genre', name: 'app_genre_add')]
    public function index(Request $request): Response
        //use Symfony\Component\HttpFoundation\Request;
    {

        //creation d'un nouveau genre
        $genre = new Genre();


        //use App\Form\GenreType;
        $form = $this->createForm(GenreType::class, $genre);

        //dire au formulaire d'écouter la request
        // (récupérer les paramètres POST GET etc)
        $form->handleRequest($request);

        //gerer la soumission et validation de notre formulaire
        if ($form->isSubmitted() && $form->isValid()) {


            $this->entityManager->persist($genre);
            $this->entityManager->flush();


            $this->redirectToRoute('app_genre_add');
        }

        return $this->render('genre/index.html.twig', [
            'controller_name' => 'GenreController',
            //creer la vue du formulaire et le donner à twig
            'form' => $form->createView()
        ]);
    }
}
