<?php
namespace App\Transmitter;

abstract class Transmitter
{
    protected $machine;

    const ROVER_ORDER = 'R';
    const ROVER_ERROR = 'E';

    public function __construct(TransmitterCapableMachine $machine, EventHandler $event)
    {
        $this->machine = $machine;
        $this->event = $event;
    }

    public function sendMessage(Message $message)
    {
        $this->event->trigger($message);
    }

    abstract public function recivedMessage(Message $message);
}
