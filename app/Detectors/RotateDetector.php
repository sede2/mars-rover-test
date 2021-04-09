<?php
namespace App\Detectors;

use App\Map\MapPlain;
use App\Map\MovableObject;

class RotateDetector extends Detector
{
    public function __construct()
    {
        parent::__construct(parent::TYPE_ROTATE_DETECTOR);
    }

    public function check(MapPlain $map, MovableObject $object)
    {
        return true;
    }

}
