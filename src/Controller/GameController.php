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
use App\Repository\ScoreRepository;
use App\Service\DistanceCalculator;
use App\Entity\Game;
use App\Entity\City;
use App\Entity\User;
use App\Entity\GameScore;
use App\Repository\CityRepository;
use App\Repository\GameRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Doctrine\Common\Collections\ArrayCollection;


class GameController extends AbstractController
{
    private UserRepository $userRepository;
    private GameScoreRepository $gameScoreRepository;
    private GameRepository $gameRepository;

    public function __construct(UserRepository $userRepository, GameScoreRepository $gameScoreRepository, GameRepository $gameRepository)
    {
        $this->userRepository = $userRepository;
        $this->gameScoreRepository = $gameScoreRepository;
        $this->gameRepository = $gameRepository;
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
        if (!is_numeric($cityId)) {
            throw new BadRequestHttpException('Je n\'ai pas compris tes coordonnées.');
        }

        $cityId = intval($cityId);
        $city = $cityRepository->find($cityId);

        if (!$city) {
            throw $this->createNotFoundException('City not found');
        }

        // Vérifier si les valeurs de latitude et longitude sont présentes
        if (is_numeric($guessedLatitude) && is_numeric($guessedLongitude)) {
            $guessedLatitude = floatval($guessedLatitude);
            $guessedLongitude = floatval($guessedLongitude);

            // Calculer la distance entre les coordonnées devinées et les coordonnées réelles
            $distance = $distanceCalculator->calculateDistance($guessedLatitude, $guessedLongitude, $city->getLatitude(), $city->getLongitude());

            // Calculer le score en utilisant une approche logarithmique
            $score = $this->calculateScore($distance);
        } else {
            // Si les valeurs de latitude et longitude ne sont pas présentes, attribuer un score de 0
            $score = 0;
            $distance = null;
            $guessedLatitude = null;
            $guessedLongitude = null;
        }

        // Vérifier si c'est le premier round de la partie
        if ($round === 1) {
            // Effacer le score précédent de l'utilisateur pour cette partie
            $this->gameScoreRepository->deleteScoresForUserAndGame($this->getUser(), $game);
        }

        // Créer une nouvelle instance de GameScore
        $gameScore = new GameScore();
        $gameScore->setGame($game);
        $gameScore->setUser($this->getUser());
        $gameScore->setRound($round);
        $gameScore->setScore($score);

        // Enregistrer le score dans la base de données
        $this->gameScoreRepository->save($gameScore, true);

        // Mettre à jour le score total de l'utilisateur
        $user = $this->getUser();

        if ($user instanceof User) {
            $scoreTotal = $user->getScore() + $score;
            $user->setScore($scoreTotal);
            $this->userRepository->save($user, true);
        }

        // Mettre à jour le score total de la partie
        $gameScores = $this->gameScoreRepository->findBy(['game' => $game, 'user' => $this->getUser()]);
        $totalScore = array_sum(array_map(function (GameScore $gameScore) {
            return $gameScore->getScore();
        }, $gameScores));

        // Vérifier si le score total est supérieur au meilleur score de la partie
        if ($totalScore > $game->getBestScore()) {
            $game->setBestScore($totalScore);
            $game->setBestScoreUser($this->getUser());
            $this->gameRepository->save($game, true);
        }

        return $this->render('game/result.html.twig', [
            'distance' => $distance,
            'score' => $score,
            'scoreTotal' => $totalScore,
            'guessedLatitude' => $guessedLatitude,
            'guessedLongitude' => $guessedLongitude,
            'city' => $city,
            'round' => $round,
            'game' => $game,
            'totalRounds' => $game->getRounds(),
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
        $allCities = $game->getCities()->toArray();
        $totalRounds = $game->getRounds();

        if ($round === 1) {
            // Mélanger aléatoirement l'ordre des villes
            shuffle($allCities);

            // Sélectionner les villes uniques pour le jeu
            $selectedCities = array_slice($allCities, 0, $totalRounds);

            // Stocker les identifiants des villes sélectionnées dans le jeu
            $game->setCities(new ArrayCollection($selectedCities));
        }

        $cities = $game->getCities();

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

    #[Route("/city/create", name: "create_city", methods: ["GET", "POST"])]
    public function createCity(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $cityName = $request->request->get('cityName');
            $cityLatitude = $request->request->get('cityLatitude');
            $cityLongitude = $request->request->get('cityLongitude');

            // Validez les données du formulaire
            if (empty($cityName) || empty($cityLatitude) || empty($cityLongitude)) {
                // Gérez les erreurs de validation
                $this->addFlash('error', 'Veuillez remplir tous les champs requis.');
                return $this->redirectToRoute('create_city');
            }

            $city = new City();
            $city->setName($cityName);
            $city->setLatitude($cityLatitude);
            $city->setLongitude($cityLongitude);

            $entityManager->persist($city);
            $entityManager->flush();

            // Redirigez vers la page de création de partie avec un message de succès
            $this->addFlash('success', 'La ville a été ajoutée avec succès.');
            return $this->redirectToRoute('game_create');
        }

        return $this->render('city/create.html.twig');
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
