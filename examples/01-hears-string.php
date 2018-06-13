<?php

use Legionth\ReactPHP\ChatBot\Chatbot;
use React\EventLoop\Factory;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$stream = new React\Stream\ThroughStream();

// This can be seem as the chat itself
$stream->on('data', function ($data) {
    echo $data . PHP_EOL;
});

$chatbot = new Chatbot($stream);
$chatbot->hears('Hello Bot', function (Chatbot $bot) {
    $bot->says('It greeted me');
});

// The Chatbot will respond to this
$stream->write('Hello Bot');

// But it wont respond to this
$stream->write('Are you a bot?');

$loop->run();