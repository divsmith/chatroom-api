<?php
namespace Domain;


class ChatRoom
{
    protected $name;
    protected $uuid;
    protected $dateCreated;
    protected $dateUpdated;

    public function __construct($name, $dateCreated, $dateUpdated, $uuid = null)
    {
        $this->name = $name;
        $this->dateCreated = $dateCreated;
        $this->dateUpdated = $dateUpdated;
        $this->uuid = $uuid;
    }

    public function name()
    {
        return $this->name;
    }

    public function uuid()
    {
        return $this->uuid;
    }
}