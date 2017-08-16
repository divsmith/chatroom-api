<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 8/15/17
 * Time: 3:57 PM
 */

namespace Storage\Plugins\Chatroom;


use Domain\ChatRoom;

class MySQLChatRoomPlugin implements ChatRoomPluginInterface
{
    protected $db;

    public function __construct()
    {
        $this->db = new \PDO('mysql:host=172.18.0.3;dbname=cs3620', 'alpine', 'supersecretpassword');
    }

    public function getByID($id)
    {
        $statement = $this->db->prepare('SELECT uuid, dateCreated, dateUpdated, name FROM Chatrooms WHERE uuid = ?');
        $statement->execute([$id]);
        $data = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($data != null)
        {
            return new ChatRoom($data['name'], new \DateTime($data['dateCreated']), new \DateTime($data['dateUpdated']), $data['uuid']);
        }

        return null;
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function persist(ChatRoom $room)
    {
        $statement = $this->db->prepare('SELECT * FROM Chatrooms WHERE uuid = ?');
        $statement->execute([$room->uuid()]);
        $rows = $statement->rowCount();

        if ($rows == 0)
        {
            // Insert a new record into the database.
            $statement = $this->db->prepare('INSERT INTO Chatrooms(uuid, dateCreated, dateUpdated, name) VALUES(?, ?, ?, ?)');
            return $statement->execute([$room->uuid(), $room->created()->format('Y-m-d H:i:s'), $room->updated()->format('Y-m-d H:i:s'), $room->name()]);
        }
        else
        {
            // Update an existing record
            $statement = $this->db->prepare('UPDATE Chatrooms SET dateCreated = ?, dateUpdated = ?, name = ? WHERE uuid = ?');
            return $statement->execute([$room->created()->format('Y-m-d H:i:s'), $room->updated()->format('Y-m-d H:i:s'), $room->name(), $room->uuid()]);
        }
    }
}