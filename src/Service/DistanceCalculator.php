<?php

namespace App\Service;

class DistanceCalculator
{
    private const EARTH_RADIUS = 6371; // Rayon de la Terre en kilomètres

    /**
     * Calculates the distance between two points specified by latitude and longitude
     *
     * @param float $lat1 Latitude of the first point
     * @param float $lon1 Longitude of the first point
     * @param float $lat2 Latitude of the second point
     * @param float $lon2 Longitude of the second point
     *
     * @return float Distance between the two points in kilometers
     */
    public function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $haversineFormula = $this->calculateHaversineFormula($lat1, $lat2, $dLat, $dLon);

        $centralAngle = 2 * atan2(sqrt($haversineFormula), sqrt(1 - $haversineFormula));

        $distance = self::EARTH_RADIUS * $centralAngle;

        return $distance;
    }

    /**
     * Calculates the Haversine formula
     *
     * @param float $lat1 Latitude of the first point
     * @param float $lat2 Latitude of the second point
     * @param float $dLat Difference in latitude
     * @param float $dLon Difference in longitude
     *
     * @return float The Haversine formula result
     */
    private function calculateHaversineFormula(float $lat1, float $lat2, float $dLat, float $dLon): float
    {
        return sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
    }
}
