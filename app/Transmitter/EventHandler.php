<?php
namespace App\Transmitter;

use App\Events\TransmitterSendMEssage;

class EventHandler
{
    public function trigger(Message $message)
    {
        TransmitterSendMEssage::dispatch($message);
    }
}
