<?php
namespace App\Transmitter;

use App\Rover;
use App\Transmitter\Exceptions\IncorrectMessageTypeException;
use App\Transmitter\Exceptions\UnhandledMessageTypeException;
use App\Utils\Exceptions\RoverException;

class RoverTransmitter extends Transmitter
{
    const NEW_ROVER_ORDER = 'R';
    const ROVER_ERROR = 'E';

    public function __construct(Rover $machine, EventHandler $event)
    {
        parent::__construct($machine, $event);
        $this->machine = $machine;
    }

    protected function getAcceptedIncomingTypes()
    {
        return [static::NEW_ROVER_ORDER];
    }

    /**
     * @param Message $message
     * @throws IncorrectMessageTypeException
     * @throws UnhandledMessageTypeException
     */
    public function recivedMessage(Message $message)
    {
        if(!$message->isFromAcceptedTypes($this->getAcceptedIncomingTypes())){
            throw new IncorrectMessageTypeException();
        }

        switch($message->getType()){
            case static::NEW_ROVER_ORDER:
                $this->newRoverOrder(NewOrderMessage::fromMessage($message));
                break;
                // In case there are more message types
            default:
                throw new UnhandledMessageTypeException();
        }
    }

    protected function newRoverOrder(NewOrderMessage $message)
    {
        $directions = $message->asDirections();
        try {
            foreach ($directions as $direction) {
                $this->machine->nextOrder($direction);
            }
        }catch(RoverException $exception){
            $this->sendMessage(new RoverMessage(static::ROVER_ERROR, $exception->getMessage()));
        }
    }
}
