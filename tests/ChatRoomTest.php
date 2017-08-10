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
        $created = new \DateTime('now');
        $updated = new \DateTime('now');

        $room = new ChatRoom($name, $created, $updated, $uuid);

        $this->assertEquals($name, $room->name());
        $this->assertEquals($created, $room->created());
        $this->assertEquals($updated, $room->created());
        $this->assertEquals($uuid, $room->uuid());
    }
}