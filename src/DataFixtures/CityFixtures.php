<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $cities = [
            ['name' => 'Paris', 'latitude' => 48.8566, 'longitude' => 2.3522],
            ['name' => 'New York', 'latitude' => 40.7128, 'longitude' => -74.0060],
            ['name' => 'Tokyo', 'latitude' => 35.6895, 'longitude' => 139.6917],
            ['name' => 'Londres', 'latitude' => 51.5074, 'longitude' => -0.1278],
            ['name' => 'Dubaï', 'latitude' => 25.2048, 'longitude' => 55.2708],
            ['name' => 'Barcelone', 'latitude' => 41.3851, 'longitude' => 2.1734],
            ['name' => 'Rome', 'latitude' => 41.9028, 'longitude' => 12.4964],
            ['name' => 'Rio de Janeiro', 'latitude' => -22.9068, 'longitude' => -43.1729],
            ['name' => 'Sydney', 'latitude' => -33.8688, 'longitude' => 151.2093],
            ['name' => 'Le Cap', 'latitude' => -33.9249, 'longitude' => 18.4241],
            ['name' => 'Moscou', 'latitude' => 55.7558, 'longitude' => 37.6173],
            ['name' => 'Istanbul', 'latitude' => 41.0082, 'longitude' => 28.9784],
            ['name' => 'Bangkok', 'latitude' => 13.7563, 'longitude' => 100.5018],
            ['name' => 'Singapour', 'latitude' => 1.3521, 'longitude' => 103.8198],
            ['name' => 'Hong Kong', 'latitude' => 22.3193, 'longitude' => 114.1694],
            ['name' => 'Toronto', 'latitude' => 43.6532, 'longitude' => -79.3832],
            ['name' => 'Berlin', 'latitude' => 52.5200, 'longitude' => 13.4050],
            ['name' => 'Amsterdam', 'latitude' => 52.3676, 'longitude' => 4.9041],
            ['name' => 'Vienne', 'latitude' => 48.2082, 'longitude' => 16.3738],
            ['name' => 'Prague', 'latitude' => 50.0755, 'longitude' => 14.4378],
            ['name' => 'Budapest', 'latitude' => 47.4979, 'longitude' => 19.0402],
            ['name' => 'Athènes', 'latitude' => 37.9838, 'longitude' => 23.7275],
            ['name' => 'Stockholm', 'latitude' => 59.3293, 'longitude' => 18.0686],
            ['name' => 'Oslo', 'latitude' => 59.9139, 'longitude' => 10.7522],
            ['name' => 'Helsinki', 'latitude' => 60.1699, 'longitude' => 24.9384],
            ['name' => 'Copenhague', 'latitude' => 55.6761, 'longitude' => 12.5683],
            ['name' => 'Dublin', 'latitude' => 53.3498, 'longitude' => -6.2603],
            ['name' => 'Édimbourg', 'latitude' => 55.9533, 'longitude' => -3.1883],
            ['name' => 'Lisbonne', 'latitude' => 38.7223, 'longitude' => -9.1393],
            ['name' => 'Marrakech', 'latitude' => 31.6295, 'longitude' => -7.9811],
            ['name' => 'Le Caire', 'latitude' => 30.0444, 'longitude' => 31.2357],
            ['name' => 'Jérusalem', 'latitude' => 31.7683, 'longitude' => 35.2137],
            ['name' => 'Pékin', 'latitude' => 39.9042, 'longitude' => 116.4074],
            ['name' => 'Séoul', 'latitude' => 37.5665, 'longitude' => 126.9780],
            ['name' => 'Kyoto', 'latitude' => 35.0116, 'longitude' => 135.7681],
            ['name' => 'Mumbai', 'latitude' => 19.0760, 'longitude' => 72.8777],
            ['name' => 'New Delhi', 'latitude' => 28.6139, 'longitude' => 77.2090],
            ['name' => 'Katmandou', 'latitude' => 27.7172, 'longitude' => 85.3240],
            ['name' => 'Hanoï', 'latitude' => 21.0278, 'longitude' => 105.8342],
            ['name' => 'Kuala Lumpur', 'latitude' => 3.1390, 'longitude' => 101.6869],
            ['name' => 'Jakarta', 'latitude' => -6.2088, 'longitude' => 106.8456],
            ['name' => 'Melbourne', 'latitude' => -37.8136, 'longitude' => 144.9631],
            ['name' => 'Auckland', 'latitude' => -36.8485, 'longitude' => 174.7633],
            ['name' => 'Vancouver', 'latitude' => 49.2827, 'longitude' => -123.1207],
            ['name' => 'San Francisco', 'latitude' => 37.7749, 'longitude' => -122.4194],
            ['name' => 'Los Angeles', 'latitude' => 34.0522, 'longitude' => -118.2437],
            ['name' => 'Mexico', 'latitude' => 19.4326, 'longitude' => -99.1332],
            ['name' => 'Buenos Aires', 'latitude' => -34.6037, 'longitude' => -58.3816],
            ['name' => 'Santiago', 'latitude' => -33.4489, 'longitude' => -70.6693]
        ];
        
        foreach ($cities as $cityData) {
            $city = new City();
            $city->setName($cityData['name']);
            $city->setLatitude($cityData['latitude']);
            $city->setLongitude($cityData['longitude']);

            $manager->persist($city);
        }

        $manager->flush();
    }
}
