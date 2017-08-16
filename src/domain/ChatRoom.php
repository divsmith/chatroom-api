<?php
namespace Domain;


class ChatRoom
{
    protected $name;
    protected $uuid;
    protected $dateCreated;
    protected $dateUpdated;
    protected $archived = false;

    public function __construct($name, $dateCreated, $dateUpdated, $uuid)
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

    public function name($name = null)
    {
        if ($name == null)
        {
            return $this->name;
        }
        else
        {
            $this->name = $name;
            $this->dateUpdated = new \DateTime('now');
        }
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