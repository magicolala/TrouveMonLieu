<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CityRepository;

class AppController extends AbstractController
{
    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $city = $this->cityRepository->findRandomCity();

        return $this->render('app/index.html.twig', [
            'city' => $city,
        ]);
    }


    #[Route("/game/check-answer", name: "game_check_answer", methods: "POST")]
    public function checkAnswer(Request $request): Response
    {
        // Récupérer les coordonnées soumises par le joueur
        $guessedLatitude = $request->request->get('latitude');
        $guessedLongitude = $request->request->get('longitude');

        // Récupérer les coordonnées réelles de la ville
        $cityId = $request->request->get('cityId');
        $city = $this->cityRepository->find($cityId);

        // Calculer la distance entre les coordonnées devinées et les coordonnées réelles
        $distance = $this->calculateDistance($guessedLatitude, $guessedLongitude, $city->getLatitude(), $city->getLongitude());

        // Calculer le score en utilisant une approche logarithmique
        $baseScore = 1000;
        $score = round($baseScore - log($distance + 1) * 100);

        return $this->render('app/result.html.twig', [
            'distance' => $distance,
            'score' => $score,
            'guessedLatitude' => $guessedLatitude,
            'guessedLongitude' => $guessedLongitude,
            'city' => $city,
        ]);
    }

    #[Route("/game/validate-city/{cityId}", name: "app_validate_city")]
    public function validateCity(int $cityId): Response
    {
        $city = $this->cityRepository->find($cityId);

        if (!$city) {
            throw $this->createNotFoundException('La ville n\'existe pas.');
        }

        // Marquer la ville comme validée (vous pouvez ajouter une propriété "validated" à l'entité City)
        $city->setValidated(true);
        $this->cityRepository->save($city, true);

        // Rediriger vers la page d'accueil ou afficher un message de confirmation
        return $this->redirectToRoute('app_home');
    }


    /**
     * Calcule la distance entre deux coordonnées géographiques
     *
     * @param float $lat1 Latitude du premier point
     * @param float $lon1 Longitude du premier point
     * @param float $lat2 Latitude du deuxième point
     * @param float $lon2 Longitude du deuxième point
     * @return float La distance en kilomètres
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Rayon de la Terre en kilomètres
        $lat1 = floatval($lat1);
        $lon1 = floatval($lon1);
        $lat2 = floatval($lat2);
        $lon2 = floatval($lon2);
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }
}
