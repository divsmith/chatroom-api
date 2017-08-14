<?php
namespace Domain;


use Domain\Exceptions\InvalidEmailException;

class User
{
    protected $email;
    protected $alias;
    protected $chatRoomID;

    public function email()
    {
        return $this->email;
    }

    public function alias()
    {
        return $this->alias;
    }

    public function chatRoomID()
    {
        return $this->chatRoomID;
    }

    public function __construct($email, $alias, $chatRoomID = null)
    {
        // Validate email address
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new InvalidEmailException();
        }
        else
        {
            $this->email = $email;
            $this->alias = $alias;
            $this->chatRoomID = $chatRoomID;
        }
    }
}