<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Game;

class GameController extends AbstractController
{

    #[Route('/game/create', name: 'game_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupérer l'utilisateur actuellement connecté
            $game->setUser($user); // Associer le jeu à l'utilisateur créateur

            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash('success', 'Le jeu a été créé avec succès.');

            return $this->redirectToRoute('app_home', ['id' => $game->getId()]);
        }

        return $this->render('game/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/game/{id}', name: 'app_game')]
    public function game(Game $game): Response
    {
        $city = $game->getCities()->first();
        $round = 1; // Définissez la valeur appropriée pour le round actuel

        return $this->render('game/game.html.twig', [
            'game' => $game,
            'city' => $city,
            'round' => $round,
        ]);
    }
}
