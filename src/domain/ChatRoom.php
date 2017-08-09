<?php
namespace Domain;


class ChatRoom
{
    protected $name;
    protected $uuid;

    public function __construct($name, $uuid = null)
    {
        $this->name = $name;
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