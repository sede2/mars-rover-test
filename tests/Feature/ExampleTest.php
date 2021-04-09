<?php

namespace Tests\Feature;

use App\Detectors\Collection;
use App\Detectors\ForwardDetector;
use App\Detectors\RotateDetector;
use App\Map\Direction;
use App\Mars;
use App\Rover;
use App\Transmitter\EventHandler;
use App\Transmitter\Message;
use App\Transmitter\RoverMessage;
use App\Transmitter\RoverTransmitter;
use App\Transmitter\Transmitter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testRoverIsOnMars()
    {
        $mars = Mars::generate(10, 10);
        $rover = new Rover($mars, 5, 5, new Direction(Direction::NORTH), new Collection([new ForwardDetector(), new RotateDetector()]));

        $this->assertTrue($rover->render() === $mars->render()[5][5]); // rover is on given position
    }

    public function testObjectIsOnMars()
    {
        $mars = Mars::generate(10, 10);
        $obstacle = new \App\Map\Obstacle($mars, 4, 4);
        $mars->addItem($obstacle, 4, 4);

        $this->assertTrue($obstacle->render() === $mars->render()[4][4]); // object is on given position
    }

    public function testRoverCanMoveOnEmptyMars()
    {
        $mars = Mars::generate(10, 10);
        $rover = new Rover($mars, 5, 5, new Direction(Direction::NORTH), new Collection([new ForwardDetector(), new RotateDetector()]));

        $eventHandler = new class extends EventHandler{
            public $hasMessage;
            public function trigger(Message $message)
            {
                $this->hasMessage = true;
            }
        };
        $transmitter = new RoverTransmitter($rover, $eventHandler);

        $transmitter->recivedMessage(new RoverMessage(Transmitter::ROVER_ORDER, 'F'));
        $this->assertTrue($rover->movedOnLastAttempt()); //has moved
        $this->assertTrue(!$eventHandler->hasMessage); // rover didn't send a message
        $this->assertTrue($rover->render() === $mars->render()[5][4]); // is on target position
        $this->assertTrue($rover->render() !== $mars->render()[5][5]); // isn't on origial position
    }

    public function testRoverDetectsCollisionOnMarsAndDoesntMove()
    {
        $mars = Mars::generate(10, 10);
        $rover = new Rover($mars, 5, 5, new Direction(Direction::NORTH), new Collection([new ForwardDetector(), new RotateDetector()]));

        $mars->addItem(new \App\Map\Obstacle($mars, 4, 4), 4, 4);
        $mars->addItem(new \App\Map\Obstacle($mars, 4, 5), 4, 5);
        $mars->addItem(new \App\Map\Obstacle($mars, 4, 6), 4, 6);
        $mars->addItem(new \App\Map\Obstacle($mars, 5, 4), 5, 4);
        $mars->addItem(new \App\Map\Obstacle($mars, 5, 6), 5, 6);
        $mars->addItem(new \App\Map\Obstacle($mars, 6, 4), 6, 4);
        $mars->addItem(new \App\Map\Obstacle($mars, 6, 5), 6, 5);
        $mars->addItem(new \App\Map\Obstacle($mars, 6, 6), 6, 6);


        $eventHandler = new class extends EventHandler{
            public $hasMessage;
            public function trigger(Message $message)
            {
                $this->hasMessage = true;
            }
        };
        $transmitter = new RoverTransmitter($rover, $eventHandler);

        $transmitter->recivedMessage(new RoverMessage(Transmitter::ROVER_ORDER, 'F'));
        $this->assertTrue(!$rover->movedOnLastAttempt()); // didn't move
        $this->assertTrue($eventHandler->hasMessage); // sent a message
        $this->assertTrue($rover->render() === $mars->render()[5][5]); // is on original position
        $this->assertTrue($rover->render() !== $mars->render()[5][4]); // isn't on target position
    }

}
