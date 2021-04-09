<?php
namespace App\Map;


interface MapInterface
{
    public function canAddItem(int $x, int $y): bool;
    public function addItem(MapPositionableItem $item, int $x, int $y);
    public function moveObject(int $fromX, int $fromY, int $toX, int $toY);
}
