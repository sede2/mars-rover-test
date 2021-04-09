<?php
namespace App\Map;


use App\Map\Exceptions\ItemAlreadyExistsException;
use App\Map\Exceptions\MapException;
use App\Map\Exceptions\PositionNotExistsException;
use App\Map\Exceptions\RowNotExistsException;
use App\Utils\Collection;
use App\Utils\Exceptions\CollectionException;
use App\Utils\Exceptions\PositionOverflowException;

class MapPlain implements MapInterface
{
    protected $rows;

    public function __construct()
    {
        $this->rows = new Collection();
    }

    public function push(MapRow $row) : MapPlain
    {
        $this->rows->push($row);
        return $this;
    }

    public static function generate(int $x, int $y): MapPlain
    {
        $self = new self();
        $self->addRows($x, $y);
        return $self;
    }

    public function addRows(int $rows, int $cells): MapPlain
    {
        for($i = 0; $i < $rows; $i++){
            $row = new MapRow($i);
            $row->addCells($cells);
            $this->push($row);
        }
        return $this;
    }


    /**
     * @param MapPositionableItem $item
     * @param int $x
     * @param int $y
     * @return MapPlain
     * @throws ItemAlreadyExistsException
     * @throws RowNotExistsException
     * @throws Exceptions\CellNotExistsException
     * @throws PositionOverflowException
     */
    public function addItem(MapPositionableItem $item, int $x, int $y) : MapPlain
    {
        if($this->canAddItem($x, $y)) {
            $this->row($x)->addItemOnCell($item, $y);
        }
        return $this;
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     * @throws RowNotExistsException
     * @throws PositionOverflowException
     */
    protected function positionExists(int $x, int $y): bool
    {
        return $this->rowExists($x) && $this->row($x)->cellExists($y);
    }

    protected function rowExists(int $row): bool
    {
        try {
            return $this->rows->count() > $row && $this->rows->get($row);
        }catch(PositionOverflowException $exception){
            return false;
        }
    }

    /**
     * @param int $row
     * @return MapRow
     * @throws RowNotExistsException
     * @throws PositionOverflowException
     */
    protected function row(int $row): MapRow
    {
        if(! $this->rowExists($row)){
            throw new RowNotExistsException;
        }

        return $this->rows->get($row);
    }

    /**
     * @param $row
     * @param $cell
     * @return mixed
     * @throws RowNotExistsException
     * @throws Exceptions\CellNotExistsException
     * @throws PositionOverflowException
     */
    protected function itemExistsOnPosition(int $row, int $cell): bool
    {
        if(! $this->rowExists($row)){
            throw new RowNotExistsException;
        }

        return $this->row($row)->itemExistsOnPosition($cell);
    }

    public function canAddItem(int $x, int $y): bool
    {
        try {
            return $this->positionEmpty($x, $y);
        }catch(MapException $exception){
            return false;
        }catch(CollectionException $exception){
            return false;
        }
    }

    /**
     * @param $x
     * @param $y
     * @return bool
     * @throws Exceptions\CellNotExistsException
     * @throws ItemAlreadyExistsException
     * @throws PositionNotExistsException
     * @throws PositionOverflowException
     * @throws RowNotExistsException
     */
    protected function positionEmpty($x, $y): bool
    {
        if(!$this->positionExists($x, $y)){
            throw new PositionNotExistsException;
        }

        if($this->itemExistsOnPosition($x, $y)){
            throw new ItemAlreadyExistsException;
        }
        return true;
    }

    /**
     * @param int $fromX
     * @param int $fromY
     * @param int $toX
     * @param int $toY
     * @throws Exceptions\CellAlreadyEmptyException
     * @throws Exceptions\CellNotExistsException
     * @throws ItemAlreadyExistsException
     * @throws PositionOverflowException
     * @throws RowNotExistsException
     */
    public function moveObject(int $fromX, int $fromY, int $toX, int $toY)
    {
        if($this->canAddItem($toX, $toY)){
            $item = $this->row($fromX)->getItem($fromY);
            $this->row($fromX)->deleteItem($fromY);
            $this->addItem($item, $toX, $toY);
        }
    }

    public function getCell($x, $y)
    {
        return $this->row($x)->cell($y);
    }

    public function countRows()
    {
        return $this->rows->count();
    }

    public function countCells()
    {
        return $this->rows->get(0)->countCells();
    }

    public function render()
    {
        return $this->rows->map(function($row){
            return $row->render();
        });
    }
}
