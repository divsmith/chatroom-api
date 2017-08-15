<?php
namespace Test;


use Domain\Message;

class MessageTest extends \Codeception\Test\Unit
{
    /**
     * @var \Test\
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testConstructor()
    {
        $userID = '17';
        $chatRoomID = '10';
        $message = "I'm a message!";
        $dateCreated = new \DateTime('now');

        $message = new Message($userID, $chatRoomID, $message, $dateCreated);

        $this->assertEquals($userID, $message->userID());
        $this->assertEquals($chatRoomID, $message->chatRoomID());
        $this->assertEquals($dateCreated, $message->created());
    }
}