<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 8/16/17
 * Time: 1:26 PM
 */

namespace Storage\Jacks;


use Storage\Plugins\Message\MessagePluginInterface;

class MessageJack
{
    protected $plugin;

    public function __construct(MessagePluginInterface $plugin)
    {
        $this->plugin = $plugin;
    }

}