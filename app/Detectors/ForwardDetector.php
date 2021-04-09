<?php
namespace App\Detectors;

use App\Detectors\Exceptions\ForwardDetectorException;
use App\Map\MapPlain;
use App\Map\MovableObject;

class ForwardDetector extends Detector
{
    public function __construct()
    {
        parent::__construct(parent::TYPE_FORWARD_DETECTOR);
    }

    /**
     * @param MapPlain $map
     * @param MovableObject $object
     * @return bool
     * @throws ForwardDetectorException
     */
    public function check(MapPlain $map, MovableObject $object)
    {
        if($map->getCell($object->getNextX(), $object->getNextY())->hasItem()){
            throw new ForwardDetectorException();
        }
        return true;
    }

}
