<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 8/14/17
 * Time: 11:05 AM
 */

namespace Storage\User\UserPluginInterface;


use Domain\User;

interface UserPluginInterface
{
    public function getByEmail($email);
    public function persist(User $user);
    public function getAll();
    public function delete($email);
}