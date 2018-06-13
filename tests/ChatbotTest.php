<?php

use Legionth\ReactPHP\ChatBot\Chatbot;

class ChatbotTest extends TestCase
{
    public function testChatbotHearsExactString()
    {
        $stream = new React\Stream\ThroughStream();

        $cachedMessages = '';
        $stream->on('data', function ($data) use (&$cachedMessages) {
             $cachedMessages .= $data . PHP_EOL;
        });

        $chatbot = new Chatbot($stream);
        $chatbot->hears('Hello Bot', function (Chatbot $bot) {
            $bot->says('It greeted me');
        });

        $stream->write('Hello Bot');

        $this->assertEquals($cachedMessages,
            'Hello Bot' . PHP_EOL .
            'It greeted me' . PHP_EOL);
    }

    public function testChatbotHearsNotTheExactString()
    {
        $stream = new React\Stream\ThroughStream();

        $cachedMessages = '';
        $stream->on('data', function ($data) use (&$cachedMessages) {
            $cachedMessages .= $data . PHP_EOL;
        });

        $chatbot = new Chatbot($stream);
        $chatbot->hears('Hello Bot', function (Chatbot $bot) {
            $bot->says('It greeted me');
        });

        $stream->write('Are you a bot?');

        $this->assertEquals($cachedMessages,'Are you a bot?' . PHP_EOL);
    }
}