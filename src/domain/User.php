<?php
namespace Domain;


use Ramsey\Uuid\Uuid;

class User
{
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

    public function __construct($email, $alias)
    {
        $this->email = $email;
        $this->alias = $alias;
    }
}