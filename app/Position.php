<?php

namespace Dibs;

use Illuminate\Database\Eloquent\Model;

class Position
{
    function __construct() {
        
    }
    
    function getDistance($latitudeTo, $longitudeTo, $earthRadius = 6371) //By default returns in KM
    {
      // convert from degrees to radians
      //haversineGreatCircleDistance
      $latFrom = deg2rad($this->lat);
      $lonFrom = deg2rad($this->lng);
      $latTo = deg2rad($latitudeTo);
      $lonTo = deg2rad($longitudeTo);
    
      $latDelta = $latTo - $latFrom;
      $lonDelta = $lonTo - $lonFrom;
    
      $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
      return $angle * $earthRadius;
    }
    
    
    public function getDistanceToUser()
    {
        return $this->distanceToUser;
    }

    public function setDistanceToUser($value)
    {
        $this->distanceToUser = $value;
    }
    
    public $lat;
    public $lng;
    public $distanceToUser = 0;
    
    
    
}
