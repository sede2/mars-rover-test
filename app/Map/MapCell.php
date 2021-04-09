<?php
namespace App\Map;


use App\Map\Exceptions\CellAlreadyEmptyException;
use App\Map\Exceptions\ItemAlreadyExistsException;

class MapCell
{
    protected $item;
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function hasItem(): bool
    {
        return $this->item && $this->item !== null;
    }

    /**
     * @param MapPositionableItem $item
     * @return MapCell
     * @throws ItemAlreadyExistsException
     */
    public function addItem(MapPositionableItem $item): self
    {
        if($this->hasItem()){
            throw new ItemAlreadyExistsException($this->id);
        }
        $this->item = $item;

        return $this;
    }

    /**
     * @throws CellAlreadyEmptyException
     */
    public function deleteItem()
    {
        if(! $this->hasItem()) {
            throw new CellAlreadyEmptyException($this->id);
        }
        $this->item = null;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function render()
    {
        return $this->item ? $this->item->render() : '-';
    }

}
