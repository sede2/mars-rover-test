<?php
namespace App;

use App\Detectors\Collection;
use App\Map\Direction;
use App\Map\MapInterface;
use App\Map\MovableObject;
use App\Transmitter\TransmitterCapableMachine;
use App\Utils\Exceptions\CannotMoveException;
use App\Utils\Exceptions\CannotRotateException;
use App\Utils\Exceptions\RoverException;

class Rover extends MovableObject implements TransmitterCapableMachine
{
    protected $detectorCollection;
    protected $process;

    protected $movedOnLastOrder = false;

    public function __construct(MapInterface $map, int $x, int $y, Direction $direction, Collection $detectors)
    {
        parent::__construct($map, $x, $y, $direction);
        $this->detectorCollection = $detectors;
    }

    public function movedOnLastAttempt()
    {
        return $this->movedOnLastOrder;
    }

    /**
     * @throws RoverException
     */
    public function nextOrder(callable $direction)
    {
        $this->process = $direction($this);
        $this->saveMovement();
    }

    /**
     * @throws RoverException
     */
    protected function saveMovement()
    {
        $isSave = false;
        $this->movedOnLastOrder = false;
        try{
            $this->checkNextMovementIsSave();
            $isSave = true;
        }catch(RoverException $exception){
            throw $exception;
        }

        if($isSave){
            $this->movedOnLastOrder = true;
            $this->move();
        }
    }

    /**
     * @return bool
     * @throws CannotMoveException
     * @throws CannotRotateException
     */
    protected function checkNextMovementIsSave()
    {
        if($this->needsToRotate()) {
            if(! $this->detectorCollection->canRotate($this->map, $this)) {
                throw new CannotRotateException;
            }
            $this->rotate($this->process);
        }
        if ($this->detectorCollection->canMoveForward($this->map, $this)) {
            return true;
        }

        throw new CannotMoveException;
    }

    protected function needsToRotate()
    {
        $this->direction->isSame($this->process);
    }

    public function render()
    {
        return $this->direction ? $this->direction->getIdentifier() : 'R';
    }
}
