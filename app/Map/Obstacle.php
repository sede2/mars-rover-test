<?php
namespace App\Map;

class Obstacle extends PositionableObject
{
    public function render()
    {
        return 'O';
    }
}
