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
            ['name' => 'Paris', 'latitude' => 48.851675052204, 'longitude' => 2.3420479050194, 'country' => 'FR'],
            ['name' => 'New York', 'latitude' => 40.7128, 'longitude' => -74.006, 'country' => 'US'],
            ['name' => 'Tokyo', 'latitude' => 35.679246248694, 'longitude' => 139.77165379214, 'country' => 'JP'],
            ['name' => 'Londres', 'latitude' => 51.501005607609, 'longitude' => -0.12621283729122, 'country' => 'GB'],
            ['name' => 'Dubaï', 'latitude' => 25.2048, 'longitude' => 55.2708, 'country' => 'AE'],
            ['name' => 'Barcelone', 'latitude' => 41.381800306741, 'longitude' => 2.1826657264263, 'country' => 'ES'],
            ['name' => 'Rome', 'latitude' => 41.893940789381, 'longitude' => 12.477420646713, 'country' => 'IT'],
            ['name' => 'Rio de Janeiro', 'latitude' => -22.9068, 'longitude' => -43.1729, 'country' => 'BR'],
            ['name' => 'Sydney', 'latitude' => -33.869070218156, 'longitude' => 151.21, 'country' => 'AU'],
            ['name' => 'Moscou', 'latitude' => 55.7558, 'longitude' => 37.6173, 'country' => 'RU'],
            ['name' => 'Istanbul', 'latitude' => 41.0082, 'longitude' => 28.9784, 'country' => 'TR'],
            ['name' => 'Bangkok', 'latitude' => 13.7563, 'longitude' => 100.5018, 'country' => 'TH'],
            ['name' => 'Singapour', 'latitude' => 1.3616046021291, 'longitude' => 103.83271069193, 'country' => 'SG'],
            ['name' => 'Hong Kong', 'latitude' => 22.3193, 'longitude' => 114.1694, 'country' => 'HK'],
            ['name' => 'Berlin', 'latitude' => 52.52455440664, 'longitude' => 13.407884268635, 'country' => 'DE'],
            ['name' => 'Amsterdam', 'latitude' => 52.369984222579, 'longitude' => 4.8923579130972, 'country' => 'NL'],
            ['name' => 'Vienne', 'latitude' => 48.20941402675, 'longitude' => 16.371216739018, 'country' => 'AT'],
            ['name' => 'Budapest', 'latitude' => 47.504427592208, 'longitude' => 19.037380137812, 'country' => 'HU'],
            ['name' => 'Athènes', 'latitude' => 37.9838, 'longitude' => 23.7275, 'country' => 'GR'],
            ['name' => 'Oslo', 'latitude' => 59.9139, 'longitude' => 10.7522, 'country' => 'NO'],
            ['name' => 'Helsinki', 'latitude' => 60.1699, 'longitude' => 24.9384, 'country' => 'FI'],
            ['name' => 'Dublin', 'latitude' => 53.3498, 'longitude' => -6.2603, 'country' => 'IE'],
            ['name' => 'Lisbonne', 'latitude' => 38.7223, 'longitude' => -9.1393, 'country' => 'PT'],
            ['name' => 'Jérusalem', 'latitude' => 31.7683, 'longitude' => 35.2137, 'country' => 'IL'],
            ['name' => 'Mumbai', 'latitude' => 19.076, 'longitude' => 72.8777, 'country' => 'IN'],
            ['name' => 'Katmandou', 'latitude' => 27.707422710754, 'longitude' => 85.322257544323, 'country' => 'NP'],
            ['name' => 'Kuala Lumpur', 'latitude' => 3.139, 'longitude' => 101.6869, 'country' => 'MY'],
            ['name' => 'Jakarta', 'latitude' => -6.2088, 'longitude' => 106.8456, 'country' => 'ID'],
            ['name' => 'Melbourne', 'latitude' => -37.816896603323, 'longitude' => 144.96154535094, 'country' => 'AU'],
            ['name' => 'Vancouver', 'latitude' => 49.262113564418, 'longitude' => -123.05665710916, 'country' => 'CA'],
            ['name' => 'San Francisco', 'latitude' => 37.7749, 'longitude' => -122.4194, 'country' => 'US'],
            ['name' => 'Mexico', 'latitude' => 19.435999248288, 'longitude' => -99.12744930269, 'country' => 'MX'],
            ['name' => 'Santiago', 'latitude' => -33.4489, 'longitude' => -70.6693, 'country' => 'CL']
        ];

        foreach ($cities as $cityData) {
            $city = new City();
            $city->setName($cityData['name']);
            $city->setLatitude($cityData['latitude']);
            $city->setLongitude($cityData['longitude']);
            $city->setCountry($cityData['country']);

            $manager->persist($city);
        }

        $manager->flush();
    }
}
