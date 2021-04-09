<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('mars', function(){

    $mars = \App\Mars::generate(10, 10);
    $rover = new \App\Rover($mars, 5, 5, new \App\Map\Direction(\App\Map\Direction::NORTH), new \App\Detectors\Collection([new \App\Detectors\ForwardDetector(), new \App\Detectors\RotateDetector()]));
    $transmitter = new \App\Transmitter\RoverTransmitter($rover, new \App\Transmitter\EventHandler());
    $transmitter->recivedMessage(new \App\Transmitter\RoverMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'FFFFFFFFFF'));
});
