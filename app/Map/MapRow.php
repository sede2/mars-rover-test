<?php
namespace App\Map;


use App\Map\Exceptions\CellNotExistsException;
use App\Utils\Collection;

class MapRow
{
    protected $cells;
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
        $this->cells = new Collection();
    }

    public function push(MapCell $cell)
    {
        $this->cells->push($cell);
    }

    public function addCells(int $cells): self
    {
        for($i = 0; $i < $cells; $i++){
            $cell = new MapCell($this->id . ',' . $i);
            $this->push($cell);
        }
        return $this;
    }

    /**
     * @param int $cell
     * @return bool
     * @throws \App\Utils\Exceptions\PositionOverflowException
     */
    public function cellExists(int $cell): bool
    {
        return $this->cells->count() > $cell && $this->cells->get($cell);
    }

    /**
     * @param MapPositionableItem $item
     * @param int $cell
     * @return MapRow
     * @throws CellNotExistsException
     * @throws \App\Utils\Exceptions\PositionOverflowException
     * @throws Exceptions\ItemAlreadyExistsException
     */
    public function addItemOnCell(MapPositionableItem $item, int $cell): self
    {
        $this->cell($cell)->addItem($item);
        return $this;
    }

    /**
     * @param int $cell
     * @return MapCell
     * @throws CellNotExistsException
     * @throws \App\Utils\Exceptions\PositionOverflowException
     */
    public function cell(int $cell): MapCell
    {
        if(! $this->cellExists($cell)){
            throw new CellNotExistsException;
        }

        return $this->cells->get($cell);
    }

    /**
     * @param $cell
     * @return mixed
     * @throws CellNotExistsException
     * @throws \App\Utils\Exceptions\PositionOverflowException
     */
    public function itemExistsOnPosition($cell)
    {
        return $this->cell($cell)->hasItem();
    }

    /**
     * @param $cell
     * @throws CellNotExistsException
     * @throws Exceptions\CellAlreadyEmptyException
     * @throws \App\Utils\Exceptions\PositionOverflowException
     */
    public function deleteItem($cell)
    {
        $this->cell($cell)->deleteItem();
    }

    /**
     * @param $cell
     * @return mixed
     * @throws CellNotExistsException
     * @throws \App\Utils\Exceptions\PositionOverflowException
     */
    public function getItem($cell)
    {
        return $this->cell($cell)->getItem();
    }

    public function render()
    {
        return $this->cells->map(function($cell){
            return $cell->render();
        });
    }

    public function countCells()
    {
        return $this->cells->count();
    }


}
