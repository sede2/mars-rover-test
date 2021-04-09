<?php
namespace App\Map;

class Direction
{
    const NORTH = 'N';
    const EAST = 'E';
    const WEST = 'W';
    const SOUTH = 'S';

    protected $identifier;

    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    public function isSame(self $other)
    {
        return $this->identifier === $other->getIdentifier();
    }

    public function nextX()
    {
        if($this->identifier === self::WEST) return 1;
        if($this->identifier === self::EAST) return -1;
        return 0;
    }

    public function nextY()
    {
        if($this->identifier === self::SOUTH) return 1;
        if($this->identifier === self::NORTH) return -1;
        return 0;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function fromPosition($relative, MovableObject $object)
    {
        $currentDirection = $object->getDirection();
        if($relative == 'L'){
            $currentDirection->rotateLeft();
        }

        if($relative == 'R'){
            $currentDirection->rotateRight();
        }

        return $currentDirection;
    }

    public function rotateLeft()
    {
        switch($this->identifier){
            case static::NORTH:
                $this->identifier = static::WEST;
                return $this;
            case static::WEST:
                $this->identifier = static::SOUTH;
                return $this;
            case static::SOUTH:
                $this->identifier = static::EAST;
                return $this;
            case static::EAST:
                $this->identifier = static::NORTH;
                return $this;
        }
    }

    public function rotateRight()
    {
        switch($this->identifier){
            case static::NORTH:
                $this->identifier = static::EAST;
                return $this;
            case static::WEST:
                $this->identifier = static::NORTH;
                return $this;
            case static::SOUTH:
                $this->identifier = static::WEST;
                return $this;
            case static::EAST:
                $this->identifier = static::SOUTH;
                return $this;
        }
    }


}
