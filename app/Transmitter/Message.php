<?php
namespace App\Transmitter;

use App\Transmitter\Exceptions\MessageEmptyException;

class Message
{
    protected $type;
    protected $message;

    public function __construct(string $type, string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    public function getType(): string
    {
       return $this->type;
    }

    public function isFromAcceptedTypes(array $types)
    {
        return in_array($this->type, $types);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public static function fromMessage(self $message)
    {
        return new static($message->getType(), $message->getMessage());
    }
}
