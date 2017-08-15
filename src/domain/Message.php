<?php

namespace Domain;

class Message
{
    protected $userEmail;
    protected $chatRoomID;
    protected $message;
    protected $dateCreated;

    public function __construct($userID, $chatRoomID, $message,
                    $dateCreated)
    {
        $this->userEmail = $userID;
        $this->chatRoomID = $chatRoomID;
        $this->message = $message;
        $this->dateCreated = $dateCreated;
    }

    public function userID()
    {
        return $this->userEmail;
    }

    public function chatRoomID()
    {
        return $this->chatRoomID;
    }

    public function created()
    {
        return $this->dateCreated;
    }
}