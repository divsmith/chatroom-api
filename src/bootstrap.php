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

$container['chatroomjack'] = function($container) {
    $plugin = $this->get('chatroomplugin');
    return new \Storage\Jacks\ChatRoomJack($plugin);
};

$container['messagejack'] = function($container) {
    $plugin = $this->get('messageplugin');
    return new \Storage\Jacks\MessageJack($plugin);
};

$container['userjack'] = function($container) {
    $plugin = $this->get('userplugin');
    return new \Storage\Jacks\UserJack($plugin);
};

