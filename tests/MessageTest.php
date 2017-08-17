<?php
namespace Test;


use Domain\Message;
use Ramsey\Uuid\Uuid;

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
        $messageText = "I'm a message!";
        $dateCreated = new \DateTime('now');
        $dateUpdated = new \DateTime('now');
        $uuid = Uuid::uuid4()->toString();

        $message = new Message($userID, $chatRoomID, $messageText, $dateCreated, $dateUpdated, $uuid);

        $this->assertEquals($userID, $message->email());
        $this->assertEquals($chatRoomID, $message->chatRoomID());
        $this->assertEquals($dateCreated, $message->created());
        $this->assertEquals($dateUpdated, $message->updated());
        $this->assertEquals($messageText, $message->message());
        $this->assertEquals($uuid, $message->uuid());
    }

    public function testUpdate()
    {
        $userID = '17';
        $chatRoomID = '10';
        $messageText = "I'm a message!";
        $dateCreated = new \DateTime('now');
        $dateUpdated = new \DateTime('now');
        $uuid = Uuid::uuid4()->toString();

        $message = new Message($userID, $chatRoomID, $messageText, $dateCreated, $dateUpdated, $uuid);

        $this->assertEquals($userID, $message->email());
        $this->assertEquals($chatRoomID, $message->chatRoomID());
        $this->assertEquals($dateCreated, $message->created());
        $this->assertEquals($dateUpdated, $message->updated());
        $this->assertEquals($messageText, $message->message());
        $this->assertEquals($uuid, $message->uuid());

        $message->message('New message');
        $this->assertEquals('New message', $message->message());
    }
}