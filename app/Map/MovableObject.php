<?php
namespace App\Map;


class MovableObject extends PositionableObject
{
    protected $direction;

    public function __construct(MapInterface $map, int $x, int $y, Direction $direction)
    {
        parent::__construct($map, $x, $y);
        $this->direction = $direction;
    }

    protected function setDirection(Direction $direction)
    {
        $this->direction = $direction;
    }

    protected function checkDirection(Direction $direction)
    {
        $this->direction->isSame($direction);
    }

    public function move()
    {
        $this->map->moveObject($this->positionX, $this->positionY, $this->getNextX(), $this->getNextY());
        $this->positionX = $this->getNextX();
        $this->positionY = $this->getNextY();
    }

    public function getNextX()
    {
        $toX = $this->positionX + $this->direction->nextX();
        $toX = $this->map->countRows() > $toX ? $toX : 0;
        return $toX >= 0 ? $toX : $this->map->countRows() - 1;
    }

    public function getNextY()
    {
        $toY = $this->positionY + $this->direction->nextY();
        $toY = $this->map->countCells() > $toY ? $toY : 0;
        return $toY >= 0 ? $toY : $this->map->countCells() - 1;
    }

    public function rotate(Direction $direction)
    {
        $this->direction = $direction;
    }

    /**
     * @return Direction
     */
    public function getDirection()
    {
        return $this->direction;
    }


}
