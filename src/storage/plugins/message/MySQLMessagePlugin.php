<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 8/16/17
 * Time: 11:19 AM
 */

namespace Storage\Plugins\Message;


use Domain\Message;

class MySQLMessagePlugin implements MessagePluginInterface
{
    protected $db;

    public function __construct()
    {
        $this->db = new \PDO('mysql:host=' . getenv('MYSQL_HOST') . ';dbname=' . getenv('MYSQL_DB'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
    }

    public function delete($id)
    {
        $statement = $this->db->prepare('DELETE FROM Messages WHERE uuid = ?');
        return $statement->execute([$id]);
    }

    public function persist(Message $message)
    {
        $statement = $this->db->prepare('SELECT * FROM Messages WHERE uuid = ?');
        $statement->execute([$message->uuid()]);
        $rows = $statement->rowCount();

        if ($rows == 0)
        {
            // Insert a new record into the database.
            $statement = $this->db->prepare('INSERT INTO Messages(uuid, dateCreated, dateUpdated, message, email, chatroomID) VALUES(?, ?, ?, ?, ?, ?)');
            return $statement->execute([$message->uuid(), $message->created()->format('Y-m-d H:i:s'), $message->updated()->format('Y-m-d H:i:s'),
                $message->message(), $message->email(), $message->chatRoomID()]);
        }
        else
        {
            // Update an existing record
            $statement = $this->db->prepare('UPDATE Messages SET dateCreated = ?, dateUpdated = ?, message = ?, email = ?, chatroomID = ? WHERE uuid = ?');
            return $statement->execute([$message->created()->format('Y-m-d H:i:s'), $message->updated()->format('Y-m-d H:i:s'),
                $message->message(), $message->email(), $message->chatRoomID()]);
        }
    }

    public function getByID($id)
    {
        $statement = $this->db->prepare('SELECT uuid, dateCreated, dateUpdated, message, email, chatroomID FROM Messages WHERE uuid = ?');
        $statement->execute([$id]);
        $data = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($data != null)
        {
            return new Message($data['email'], $data['chatroomID'], $data['message'], new \DateTime($data['dateCreated']),
                new \DateTime($data['dateUpdated']), $data['uuid']);
        }

        return null;

    }

    public function getByDateRange($chatroomID, \DateTime $start, \DateTime $end)
    {
        $statement = $this->db->prepare('SELECT uuid, dateCreated, dateUpdated, message, email, chatroomID FROM Messages WHERE chatroomID = ?
                                            AND dateCreated BETWEEN ? AND ?');

        $statement->execute([$chatroomID, $start->format('Y-m-d H:i:s'), $end->format('Y-m-d H:i:s')]);
        $messages = [];

        foreach($statement as $data)
        {
            $messages[] = new Message($data['email'], $data['chatroomID'], $data['message'], new \DateTime($data['dateCreated']),
                new \DateTime($data['dateUpdated']), $data['uuid']);
        }

        return $messages;
    }
}