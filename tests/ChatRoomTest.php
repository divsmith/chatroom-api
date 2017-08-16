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
        $this->assertFalse($room->archived());
    }

    public function testArchivedDate()
    {
        $name = 'Chat Room';
        $uuid = Uuid::uuid4()->toString();
        $created = new \DateTime('now');
        $updated = new \DateTime('now');

        $updated = $updated->sub(date_interval_create_from_date_string('8 days'));

        $room = new ChatRoom($name, $created, $updated, $uuid);

        $this->assertTrue($room->archived());
    }

    public function testDateTimeUpdate()
    {
        $name = 'Chat Room';
        $uuid = Uuid::uuid4()->toString();
        $created = new \DateTime('now');
        $updated = new \DateTime('now');

        $room = new ChatRoom($name, $created, $updated, $uuid);
        sleep(1);
        $room->name('Something Else');

        $this->assertNotEquals($updated, $room->updated());
        $this->assertEquals('Something Else', $room->name());
    }
}