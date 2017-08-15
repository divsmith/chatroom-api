<?php
namespace Domain;


class ChatRoom
{
    protected $name;
    protected $uuid;
    protected $dateCreated;
    protected $dateUpdated;
    protected $archived = false;

    public function __construct($name, $dateCreated, $dateUpdated, $uuid = null)
    {
        $this->name = $name;
        $this->dateCreated = $dateCreated;
        $this->dateUpdated = $dateUpdated;
        $this->uuid = $uuid;

        $now = new \DateTime('now');
        if ($now->diff($dateUpdated)->format("%a") > 7)
        {
            $this->archived = true;
        }
    }

    public function archived()
    {
        return $this->archived;
    }

    public function name()
    {
        return $this->name;
    }

    public function created()
    {
        return $this->dateCreated;
    }

    public function updated()
    {
        return $this->dateUpdated;
    }

    public function uuid()
    {
        return $this->uuid;
    }
}