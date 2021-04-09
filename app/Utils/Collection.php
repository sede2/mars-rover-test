<?php
namespace App\Utils;

use App\Utils\Exceptions\PositionOverflowException;

class Collection
{
    protected $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function push($item): self
    {
        array_push($this->items, $item);
        return $this;
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @param int $position
     * @return mixed
     * @throws PositionOverflowException
     */
    public function get(int $position)
    {
        if($position >= $this->count()){
            throw new PositionOverflowException();
        }
        return $this->items[$position];
    }

    public function each(callable $function)
    {
        foreach ($this->items as $item){
            $function($item);
        }
    }

    public function map(callable $function)
    {
        return array_map($function, $this->items);
    }
}
