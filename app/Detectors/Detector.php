<?php
namespace App\Detectors;

use App\Map\MapPlain;
use App\Map\MovableObject;

abstract class Detector
{
    const TYPE_ROTATE_DETECTOR = 'rotate';
    const TYPE_FORWARD_DETECTOR = 'forward';

    protected $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function isFromType(string $type)
    {
        return $this->type === $type;
    }

    abstract public function check(MapPlain $map, MovableObject $object);
}
