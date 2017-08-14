<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 8/14/17
 * Time: 12:16 PM
 */

namespace Storage\User;


use Domain\User;
use Storage\User\UserPluginInterface\UserPluginInterface;

class RedisUserPlugin implements UserPluginInterface
{
    public function getByEmail($email)
    {
        // TODO: Implement getByEmail() method.
    }

    public function persist(User $user)
    {
        // TODO: Implement persist() method.
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }
}