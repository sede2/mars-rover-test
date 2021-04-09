<?php
namespace App\Detectors;

use App\Detectors\Exceptions\DetectorException;
use App\Map\MapPlain;
use App\Map\MovableObject;

class Collection extends \App\Utils\Collection
{
    public function addDetector(Detector $detector)
    {
        $this->push($detector);
    }

    protected function checkByType($type, MapPlain $map, MovableObject $object)
    {
        try {
            $this->filterByType($type)->each(function (Detector $detector) use ($map, $object){
                $detector->check($map, $object);
            });
        }catch(DetectorException $e){
            return false;
        }

        return true;
    }

    public function canRotate(MapPlain $map, MovableObject $object)
    {
        return $this->checkByType(DETECTOR::TYPE_ROTATE_DETECTOR, $map, $object);
    }

    public function canMoveForward(MapPlain $map, MovableObject $object)
    {
        return $this->checkByType(DETECTOR::TYPE_FORWARD_DETECTOR, $map, $object);
    }

    public function filterByType($type)
    {
        return new self(array_filter($this->items, function(Detector $detector) use ($type){
            return $detector->isFromType($type);
        }));
    }


}
