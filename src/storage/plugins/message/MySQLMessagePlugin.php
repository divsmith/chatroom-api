<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 8/16/17
 * Time: 11:19 AM
 */

namespace Storage\Plugins\Message;


class MySQLMessagePlugin
{
    protected $db;

    public function __construct()
    {
        $this->db = new \PDO('mysql:host=172.18.0.3;dbname=cs3620', 'alpine', 'supersecretpassword');
    }

    public function delete($id)
    {
        $statement = $this->db->prepare('DELETE FROM Messages WHERE uuid = ?');
        return $statement->execute([$id]);
    }

//    public function persist(Message $message)
//    {
//        $statement = $this->db->prepare('SELECT * FROM Messages WHERE uuid = ?');
//        $statement->execute([$message->uuid()]);
//        $rows = $statement->rowCount();
//
//        if ($rows == 0)
//        {
//            // Insert a new record into the database.
//            $statement = $this->db->prepare('INSERT INTO Messages(uuid, dateCreated, message, email, chatroomID) VALUES(?, ?, ?, ?, ?)');
//            return $statement->execute([$message->uuid(), $message->created()->format('Y-m-d H:i:s'), $room->updated()->format('Y-m-d H:i:s'), $room->name()]);
//        }
//        else
//        {
//            // Update an existing record
//            $statement = $this->db->prepare('UPDATE Chatrooms SET dateCreated = ?, dateUpdated = ?, name = ? WHERE uuid = ?');
//            return $statement->execute([$room->created()->format('Y-m-d H:i:s'), $room->updated()->format('Y-m-d H:i:s'), $room->name(), $room->uuid()]);
//        }
//    }
}