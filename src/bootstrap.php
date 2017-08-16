<?php

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

$container = $app->getContainer();

$container['chatroomplugin'] = function($container) {
    return new \Storage\Plugins\Chatroom\MySQLChatRoomPlugin();
};

$container['messageplugin'] = function($container) {
    return new \Storage\Plugins\Message\MySQLMessagePlugin();
};

$container['userplugin'] = function($container) {
    return new \Storage\User\RedisUserPlugin();
};

