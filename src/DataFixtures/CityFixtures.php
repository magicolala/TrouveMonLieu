<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager):void 
    {
        $cities = [
            ['name' => 'Paris', 'latitude' => 48.851675052204, 'longitude' => 2.3420479050194],
            ['name' => 'New York', 'latitude' => 40.7128, 'longitude' => -74.006],
            ['name' => 'Tokyo', 'latitude' => 35.679246248694, 'longitude' => 139.77165379214],
            ['name' => 'Londres', 'latitude' => 51.501005607609, 'longitude' => -0.12621283729122],
            ['name' => 'Dubaï', 'latitude' => 25.2048, 'longitude' => 55.2708],
            ['name' => 'Barcelone', 'latitude' => 41.381800306741, 'longitude' => 2.1826657264263],
            ['name' => 'Rome', 'latitude' => 41.893940789381, 'longitude' => 12.477420646713],
            ['name' => 'Rio de Janeiro', 'latitude' => -22.9068, 'longitude' => -43.1729],
            ['name' => 'Sydney', 'latitude' => -33.869070218156, 'longitude' => 151.21],
            ['name' => 'Moscou', 'latitude' => 55.7558, 'longitude' => 37.6173],
            ['name' => 'Istanbul', 'latitude' => 41.0082, 'longitude' => 28.9784],
            ['name' => 'Bangkok', 'latitude' => 13.7563, 'longitude' => 100.5018],
            ['name' => 'Singapour', 'latitude' => 1.3616046021291, 'longitude' => 103.83271069193],
            ['name' => 'Hong Kong', 'latitude' => 22.3193, 'longitude' => 114.1694],
            ['name' => 'Berlin', 'latitude' => 52.52455440664, 'longitude' => 13.407884268635],
            ['name' => 'Amsterdam', 'latitude' => 52.369984222579, 'longitude' => 4.8923579130972],
            ['name' => 'Vienne', 'latitude' => 48.20941402675, 'longitude' => 16.371216739018],
            ['name' => 'Budapest', 'latitude' => 47.504427592208, 'longitude' => 19.037380137812],
            ['name' => 'Athènes', 'latitude' => 37.9838, 'longitude' => 23.7275],
            ['name' => 'Stockholm', 'latitude' => 59.3293, 'longitude' => 18.0686],
            ['name' => 'Oslo', 'latitude' => 59.9139, 'longitude' => 10.7522],
            ['name' => 'Helsinki', 'latitude' => 60.1699, 'longitude' => 24.9384],
            ['name' => 'Dublin', 'latitude' => 53.3498, 'longitude' => -6.2603],
            ['name' => 'Lisbonne', 'latitude' => 38.7223, 'longitude' => -9.1393],
            ['name' => 'Jérusalem', 'latitude' => 31.7683, 'longitude' => 35.2137],
            ['name' => 'Mumbai', 'latitude' => 19.076, 'longitude' => 72.8777],
            ['name' => 'Katmandou', 'latitude' => 27.707422710754, 'longitude' => 85.322257544323],
            ['name' => 'Kuala Lumpur', 'latitude' => 3.139, 'longitude' => 101.6869],
            ['name' => 'Jakarta', 'latitude' => -6.2088, 'longitude' => 106.8456],
            ['name' => 'Melbourne', 'latitude' => -37.816896603323, 'longitude' => 144.96154535094],
            ['name' => 'Vancouver', 'latitude' => 49.262113564418, 'longitude' => -123.05665710916],
            ['name' => 'San Francisco', 'latitude' => 37.7749, 'longitude' => -122.4194],
            ['name' => 'Mexico', 'latitude' => 19.435999248288, 'longitude' => -99.12744930269],
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
