<?php
namespace Domain;


use Ramsey\Uuid\Uuid;

class User
{
    protected $uuid;
    protected $email;
    protected $alias;

    public function email()
    {
        return $this->email;
    }

    public function alias()
    {
        return $this->alias;
    }

    public function uuid()
    {
        return $this->uuid;
    }

    public function __construct($email, $alias, $uuid = null)
    {
        if (!isset($uuid))
        {
            $uuid = Uuid::uuid4()->toString();
        }

        $this->email = $email;
        $this->alias = $alias;
        $this->uuid = $uuid;
    }
}