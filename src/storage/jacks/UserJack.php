<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 8/14/17
 * Time: 11:02 AM
 */

namespace Storage\Jacks;


use Domain\User;
use Storage\User\UserPluginInterface\UserPluginInterface;

class UserJack
{
    protected $plugin;
    protected $builder;

    public function __construct(UserPluginInterface $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getByEmail($email)
    {
       return $this->plugin->getByEmail($email);
    }

    public function persist(User $user)
    {
        $this->plugin->persist($user);
    }

    public function getAll()
    {
        return $this->plugin->getAll();
    }
}