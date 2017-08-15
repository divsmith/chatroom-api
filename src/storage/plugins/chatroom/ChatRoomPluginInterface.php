<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 8/15/17
 * Time: 3:55 PM
 */

namespace Storage\Plugins\Chatroom;


use Domain\ChatRoom;

interface ChatRoomPluginInterface
{
    public function getByID($id);
    public function getAll();
    public function persist(ChatRoom $room);
}