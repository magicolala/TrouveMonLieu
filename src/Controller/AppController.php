<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CityRepository;
use App\Repository\UserRepository;
use App\Repository\ScoreRepository;
use App\Service\DistanceCalculator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Entity\Score;
use App\Entity\Game;
use App\Form\GameType;

class AppController extends AbstractController
{
    private CityRepository $cityRepository;
    private UserRepository $userRepository;
    private ScoreRepository $scoreRepository;

    public function __construct(CityRepository $cityRepository, UserRepository $userRepository, ScoreRepository $scoreRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->userRepository = $userRepository;
        $this->scoreRepository = $scoreRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $city = $this->cityRepository->findRandomCity();

        return $this->render('app/index.html.twig', [
            'city' => $city,
        ]);
    }

    /**
     * Vérifie la réponse du joueur et calcule le score.
     *
     * @param Request $request La requête HTTP contenant les données soumises par le joueur
     * @return Response La réponse HTTP contenant le résultat de la vérification
     */
    #[Route("/game/check-answer", name: "game_check_answer", methods: "POST")]
    public function checkAnswer(Request $request, DistanceCalculator $distanceCalculator): Response
    {
        // Récupérer les coordonnées soumises par le joueur
        $guessedLatitude = $request->request->get('latitude');
        $guessedLongitude = $request->request->get('longitude');

        // Récupérer les coordonnées réelles de la ville
        $cityId = $request->request->get('cityId');
        $city = $this->cityRepository->find($cityId);

        // Validation des entrées utilisateur
        if (!is_numeric($guessedLatitude) || !is_numeric($guessedLongitude) || !is_numeric($cityId)) {
            throw new BadRequestHttpException('Je n\'ai pas compris tes coordonnées.');
        }

        $guessedLatitude = floatval($guessedLatitude);
        $guessedLongitude = floatval($guessedLongitude);
        $cityId = intval($cityId);

        // Récupérer les coordonnées réelles de la ville
        $city = $this->cityRepository->find($cityId);

        if (!$city) {
            throw $this->createNotFoundException('City not found');
        }

        // Calculer la distance entre les coordonnées devinées et les coordonnées réelles
        $distance = $distanceCalculator->calculateDistance($guessedLatitude, $guessedLongitude, $city->getLatitude(), $city->getLongitude());

        // Calculer le score en utilisant une approche logarithmique
        $score = $this->calculateScore($distance);

        // Créer une nouvelle instance de Score
        $scoreEntity = new Score();
        $scoreEntity->setCity($city);
        $scoreEntity->setUser($this->getUser());
        $scoreEntity->setDistance($distance);
        $scoreEntity->setScore($score);

            // Enregistrer le score dans la base de données
            $this->scoreRepository->save($scoreEntity, true);

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
