<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 8/16/17
 * Time: 1:26 PM
 */

namespace Storage\Jacks;


use Domain\Message;
use Storage\Plugins\Message\MessagePluginInterface;

class MessageJack
{
    protected $plugin;

    public function __construct(MessagePluginInterface $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getByID($id)
    {
        return $this->plugin->getByID($id);
    }

    public function getByDateRange($chatroomID, \DateTime $start, \DateTime $end)
    {
        return $this->plugin->getByDateRange($chatroomID, $start, $end);
    }

    public function getAll($id)
    {
        return $this->plugin->getAll($id);
    }

    public function persist(Message $message)
    {
        return $this->plugin->persist($message);
    }

    public function delete($id)
    {
        return $this->plugin->delete($id);
    }

}