<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CityRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;

class AppController extends AbstractController
{
    private CityRepository $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(GameRepository $gameRepository): Response
    {
        $games = $gameRepository->findAll();
         
        return $this->render('app/index.html.twig', [
            'games' => $games,
        ]);
    }

    /**
     * Valide une ville.
     *
     * @param int $cityId L'identifiant de la ville à valider
     * @return RedirectResponse La réponse HTTP redirigeant vers la page d'accueil
     */
    #[Route("/game/validate-city/{cityId}", name: "app_validate_city")]
    public function validateCity(int $cityId): RedirectResponse
    {
        $city = $this->cityRepository->find($cityId);

        if (!$city) {
            throw $this->createNotFoundException('La ville n\'existe pas.');
        }

        // Marquer la ville comme validée
        $city->setValidated(true);
        $this->cityRepository->save($city, true);

        // Rediriger vers la page d'accueil ou afficher un message de confirmation
        return $this->redirectToRoute('app_home');
    }

    #[Route('/game/create', name: 'game_create')]
    public function create(Request $request): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);

        return $this->render('game/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
