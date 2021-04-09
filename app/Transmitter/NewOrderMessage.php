<?php
namespace App\Transmitter;

use App\Map\Direction;

class NewOrderMessage extends Message
{
    public function asDirections()
    {
        $self = $this;
        return array_map(function($char) use ($self){
           return function($rover) use ($char){
               return Direction::fromPosition($char, $rover);
           };
        }, str_split($this->message));
    }
}
