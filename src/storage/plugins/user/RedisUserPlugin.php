<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 8/14/17
 * Time: 12:16 PM
 */

namespace Storage\User;


use Domain\User;
use Predis\Client;
use Storage\User\UserPluginInterface\UserPluginInterface;

class RedisUserPlugin implements UserPluginInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client('tcp://' . getenv('REDIS_HOST') . ':' . getenv('REDIS_PORT'));
    }

    public function getByEmail($email)
    {
        $data = $this->client->hgetall($email);
        return new User($email, $data['alias'], $data['chatRoomID']);
    }

    public function persist(User $user)
    {
        $this->client->hmset($user->email(), ['email' => $user->email(), 'alias' => $user->alias(), 'chatRoomID' => $user->chatRoomID()]);
    }

    public function delete($email)
    {
        return $this->client->del($email);
    }
}