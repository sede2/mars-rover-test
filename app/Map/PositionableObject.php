<?php
namespace App\Map;


class PositionableObject implements MapPositionableItem
{
    protected $positionX;
    protected $positionY;
    protected $map;

    public function __construct(MapInterface $map, int $x, int $y)
    {
        $this->positionX = $x;
        $this->positionY = $y;
        $this->map = $map;
        $this->setOnMap();
    }

    public function setOnMap()
    {
        if($this->map->canAddItem($this->positionX, $this->positionY)){
            $this->map->addItem($this, $this->positionX, $this->positionY);
        }
    }

}
