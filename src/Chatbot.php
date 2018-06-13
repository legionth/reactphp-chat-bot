<?php

namespace Legionth\ReactPHP\ChatBot;

use React\Stream\DuplexStreamInterface;
use React\Stream\ReadableStreamInterface;

class Chatbot
{
    /** @var ReadableStreamInterface */
    private $stream;

    public function __construct(DuplexStreamInterface $stream)
    {
        $this->stream = $stream;
    }

    public function hears($message, $callable)
    {
        $that = $this;
        $this->stream->on('data', function ($data) use ($message, $callable, $that) {
            if ($data === $message) {
                $callable($that);
            }
        });
    }

    public function says($message)
    {
        $this->stream->write($message);
    }

    public function repeats($message, $callable)
    {

    }
}