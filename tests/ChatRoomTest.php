<?php
namespace Test;

use Domain\ChatRoom;
use Ramsey\Uuid\Uuid;

class ChatRoomTest extends \Codeception\Test\Unit
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
        $name = 'Chat Room';
        $uuid = Uuid::uuid4()->toString();

        $room = new ChatRoom($name, $uuid);

        $this->assertEquals($name, $room->name());
        $this->assertEquals($uuid, $room->uuid());
    }
}