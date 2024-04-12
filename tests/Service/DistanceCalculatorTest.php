<?php

namespace App\Tests\Service;

use App\Service\DistanceCalculator;
use PHPUnit\Framework\TestCase;

class DistanceCalculatorTest extends TestCase
{
  private DistanceCalculator $distanceCalculator;

  protected function setUp(): void
  {
    $this->distanceCalculator = new DistanceCalculator();
  }

  public function testCalculateDistanceForSamePoints(): void
  {
    $lat1 = 48.8566;
    $lon1 = 2.3522;
    $lat2 = $lat1;
    $lon2 = $lon1;

    $distance = $this->distanceCalculator->calculateDistance($lat1, $lon1, $lat2, $lon2);

    $this->assertEquals(0.0, $distance);
  }

  public function testCalculateDistanceForOppositePoints(): void
  {
    $lat1 = 48.8566;
    $lon1 = 2.3522;
    $lat2 = -48.8566;
    $lon2 = 177.6478;

    $distance = $this->distanceCalculator->calculateDistance($lat1, $lon1, $lat2, $lon2);

    $this->assertEqualsWithDelta(19670.966595376, $distance, 0.1);
  }
}
