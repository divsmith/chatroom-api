<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 8/15/17
 * Time: 3:55 PM
 */

namespace Storage\Plugins\Message;

use Domain\Message;

interface MessagePluginInterface
{
    public function getByID($id);
    public function getByDateRange($chatroomID, \DateTime $start, \DateTime $end);
    public function persist(Message $message);
    public function delete($id);
}