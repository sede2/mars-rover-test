<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');


    $mars = \App\Mars::generate(20, 20);
    $rover = new \App\Rover($mars, 2, 2, new \App\Map\Direction(\App\Map\Direction::NORTH), new App\Detectors\Collection([new \App\Detectors\ForwardDetector()]));
    $mars->addItem(new \App\Map\Obstacle($mars, 1, 1), 1, 1);
    $transmitter = new \App\Transmitter\RoverTransmitter($rover, new \App\Transmitter\EventHandler());
    echo '<h1>Inicio</h1>';

    echo '&nbsp;E<br/>';
    echo 'N S<br/>';
    echo '&nbsp;W<br/>';
    render($mars);


    echo '<h1>F</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'F'));
    render($mars);

    echo '<h1>F</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'F'));
    render($mars);

    echo '<h1>F</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'F'));
    render($mars);


    echo '<h1>R</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'R'));
    render($mars);

    echo '<h1>F</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'F'));
    render($mars);

    echo '<h1>F</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'F'));
    render($mars);

    echo '<h1>R</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'R'));
    render($mars);

    echo '<h1>F</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'F'));
    render($mars);

    echo '<h1>R</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'R'));
    render($mars);

    echo '<h1>F</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'F'));
    render($mars);

    echo '<h1>R</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'R'));
    render($mars);

    echo '<h1>R</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'R'));
    render($mars);

    echo '<h1>R</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'R'));
    render($mars);

    echo '<h1>R</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'R'));
    render($mars);

    echo '<h1>F</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'F'));
    render($mars);

    echo '<h1>RFFF</h1>';
    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'RFFF'));
    render($mars);
//
//
//    echo '<h1>F</h1>';
//    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'F'));
//    render($mars);
//
//
//    echo '<h1>F</h1>';
//    $transmitter->recivedMessage(new \App\Transmitter\NewOrderMessage(\App\Transmitter\Transmitter::ROVER_ORDER, 'F'));
//    render($mars);
});


//function __mars_helper_render($mars){
//    $render = $mars->render();
//    echo '<table style="margin: 1em">';
//    foreach($render as $row){
//        echo '<tr>';
//        foreach($row as $cell){
//            echo '<td style="border: 1px solid black; width: 2em; height: 2em; text-align: center">' . $cell . '</td>';
//        }
//        echo '</tr>';
//    }
//    echo '</table>';
//}
