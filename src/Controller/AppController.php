<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CityRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Repository\GameRepository;
use App\Repository\GameScoreRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AppController extends AbstractController
{
    private CityRepository $cityRepository;
    private GameRepository $gameRepository;

    public function __construct(CityRepository $cityRepository, GameRepository $gameRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->gameRepository = $gameRepository;
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_home')]
    public function index(GameRepository $gameRepository, GameScoreRepository $gameScoreRepository): Response
    {
        $games = $gameRepository->findAll();

        foreach ($games as $game) {
            $totalScore = $gameScoreRepository->findTotalScoreByGame($game, $this->getUser());
            $game->setUserScore($totalScore);
        }
    
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

    #[Route("/best-scores", name: "app_best_scores")]
    public function bestScores(): Response
    {
        $bestScores = $this->gameRepository->findBestScoresByGame();

        return $this->render('app/best_scores.html.twig', [
            'bestScores' => $bestScores,
        ]);
    }
}
