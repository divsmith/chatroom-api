<?php

namespace Domain;

class Message
{
    protected $userID;
    protected $chatRoomID;
    protected $message;
    protected $dateCreated;
    protected $dateUpdated;

    public function __construct($userID, $chatRoomID, $message,
                    $dateCreated, $dateUpdated)
    {
        $this->userID = $userID;
        $this->chatRoomID = $chatRoomID;
        $this->message = $message;
        $this->dateCreated = $dateCreated;
        $this->dateUpdated = $dateUpdated;
    }

    public function userID()
    {
        return $this->userID;
    }

    public function chatRoomID()
    {
        return $this->chatRoomID;
    }

    public function created()
    {
        return $this->dateCreated;
    }

    public function updated()
    {
        return $this->dateUpdated;
    }
}