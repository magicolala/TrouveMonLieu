<?php

namespace App\Service;

class DistanceCalculator
{

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
  public function calculateDistance($lat1, $lon1, $lat2, $lon2): float
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
