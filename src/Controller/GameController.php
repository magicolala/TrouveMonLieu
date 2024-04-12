<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use App\Repository\GameScoreRepository;
use App\Service\DistanceCalculator;
use App\Entity\Game;
use App\Entity\GameScore;
use App\Repository\CityRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class GameController extends AbstractController
{
    private UserRepository $userRepository;
    private GameScoreRepository $gameScoreRepository;

    public function __construct(UserRepository $userRepository, GameScoreRepository $gameScoreRepository)
    {
        $this->userRepository = $userRepository;
        $this->gameScoreRepository = $gameScoreRepository;
    }
    /**
     * Vérifie la réponse du joueur et calcule le score.
     *
     * @param Request $request La requête HTTP contenant les données soumises par le joueur
     * @return Response La réponse HTTP contenant le résultat de la vérification
     */
    #[Route("/game/check-answer/{game}/{round}", name: "game_check_answer", methods: "POST")]
    public function checkAnswer(Request $request, DistanceCalculator $distanceCalculator, CityRepository $cityRepository, Game $game, int $round): Response
    {
        // Récupérer les coordonnées soumises par le joueur
        $guessedLatitude = $request->request->get('latitude');
        $guessedLongitude = $request->request->get('longitude');

        // Récupérer les coordonnées réelles de la ville
        $cityId = $request->request->get('cityId');

        // Validation des entrées utilisateur
        if (!is_numeric($guessedLatitude) || !is_numeric($guessedLongitude) || !is_numeric($cityId)) {
            throw new BadRequestHttpException('Je n\'ai pas compris tes coordonnées.');
        }

        $guessedLatitude = floatval($guessedLatitude);
        $guessedLongitude = floatval($guessedLongitude);
        $cityId = intval($cityId);
        $city = $cityRepository->find($cityId);

        if (!$city) {
            throw $this->createNotFoundException('City not found');
        }

        // Calculer la distance entre les coordonnées devinées et les coordonnées réelles
        $distance = $distanceCalculator->calculateDistance($guessedLatitude, $guessedLongitude, $city->getLatitude(), $city->getLongitude());

        // Calculer le score en utilisant une approche logarithmique
        $score = $this->calculateScore($distance);

        // Créer une nouvelle instance de GameScore
        $gameScore = new GameScore();
        $gameScore->setGame($game); // Assurez-vous d'avoir une instance de Game disponible
        $gameScore->setUser($this->getUser());
        $gameScore->setRound($round); // Assurez-vous d'avoir la valeur du round disponible
        $gameScore->setScore($score);

        // Enregistrer le score dans la base de données
        $this->gameScoreRepository->save($gameScore, true);

        // Mettre à jour le score total de l'utilisateur
        $scoreTotal = $this->getUser()->getScore() + $score;
        $this->getUser()->setScore($scoreTotal);
        $this->userRepository->save($this->getUser(), true);

        return $this->render('app/result.html.twig', [
            'distance' => $distance,
            'score' => $score,
            'scoreTotal' => $scoreTotal,
            'guessedLatitude' => $guessedLatitude,
            'guessedLongitude' => $guessedLongitude,
            'city' => $city,
        ]);
    }

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

    #[Route('/game/{id}/{round}', name: 'app_game', defaults: ['round' => 1])]
    public function game(Game $game, int $round): Response
    {
        $cities = $game->getCities();
        $totalRounds = $game->getRounds();

        if ($round > $totalRounds) {
            // Rediriger vers une page de fin de jeu ou afficher un message
            return $this->redirectToRoute('game_end', ['id' => $game->getId()]);
        }

        $city = $cities[$round - 1];

        return $this->render('game/game.html.twig', [
            'game' => $game,
            'city' => $city,
            'round' => $round,
            'totalRounds' => $totalRounds,
        ]);
    }

    /**
     * Calculates the score based on distance from guessed coordinates.
     * 
     * Uses a logarithmic approach to reduce score as distance increases.
     * 
     * @param float $distance Distance in km between guessed and actual coordinates
     * @return int Calculated score
     */
    private function calculateScore($distance): float
    {
        $baseScore = 1000;
        $score = round($baseScore - log($distance + 1) * 100);
        return $score;
    }
}
