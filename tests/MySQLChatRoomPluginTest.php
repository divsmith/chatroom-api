<?php
namespace Test;


use Domain\ChatRoom;
use Ramsey\Uuid\Uuid;
use Storage\Plugins\Chatroom\MySQLChatRoomPlugin;

class MySQLChatRoomPluginTest extends \Codeception\Test\Unit
{
    /**
     * @var \Test\
     */
    protected $tester;
    protected $plugin;
    protected $uuids;

    protected function _before()
    {
        $this->plugin = new MySQLChatRoomPlugin();
        $this->uuids = [];
    }

    protected function _after()
    {
        foreach($this->uuids as $uuid)
        {
            $this->plugin->delete($uuid);
        }
    }

    // tests
    public function testPersistenceWithUUID()
    {
        $name = 'Chat room';
        $created = new \DateTime('now');
        $updated = new \DateTime('now');
        $uuid = Uuid::uuid4()->toString();

        $room = new ChatRoom($name, $created, $updated, $uuid);
        $this->assertTrue($this->plugin->persist($room));

        $retrieved = $this->plugin->getByID($uuid);

        $this->assertEquals($room->name(), $retrieved->name());
        $this->assertEquals($room->created(), $retrieved->created());
        $this->assertEquals($room->updated(), $retrieved->updated());
        $this->assertEquals($room->uuid(), $retrieved->uuid());

        $this->uuids[] = $uuid;
    }

    public function testUpdate()
    {
        $name = 'Chat room';
        $created = new \DateTime('now');
        $updated = new \DateTime('now');
        $uuid = Uuid::uuid4()->toString();

        $room = new ChatRoom($name, $created, $updated, $uuid);
        $this->assertTrue($this->plugin->persist($room));
        sleep(1);

        $room->name('Something Else');
        $this->assertTrue($this->plugin->persist($room));

        $retrieved = $this->plugin->getByID($uuid);

        $this->assertEquals('Something Else', $retrieved->name());
        $this->assertEquals($room->created(), $retrieved->created());
        $this->assertNotEquals($updated, $retrieved->updated());
        $this->assertEquals($room->uuid(), $retrieved->uuid());

        $this->uuids[] = $uuid;
    }

    public function testGetWithInvalidID()
    {
        $this->assertNull($this->plugin->getByID('asdfasdf'));
    }

    public function testDelete()
    {
        $name = 'Test Delete';
        $created = new \DateTime('now');
        $updated = new \DateTime('now');
        $uuid = Uuid::uuid4()->toString();

        $room = new ChatRoom($name, $created, $updated, $uuid);
        $this->plugin->persist($room);
        $this->assertEquals($room, $this->plugin->getByID($uuid));

        $this->assertTrue($this->plugin->delete($uuid));
        $this->assertNull($this->plugin->getByID($uuid));
    }

    public function testGetAll()
    {
        $uuid1 = Uuid::uuid4()->toString();
        $uuid2 = Uuid::uuid4()->toString();
        $uuid3 = Uuid::uuid4()->toString();
        $room1 = new ChatRoom('Room 1', new \DateTime('now'), new \DateTime('now'), $uuid1);
        $room2 = new ChatRoom('Room 1', new \DateTime('now'), new \DateTime('now'), $uuid2);
        $room3 = new ChatRoom('Room 1', new \DateTime('now'), new \DateTime('now'), $uuid3);

        $this->plugin->persist($room1);
        $this->plugin->persist($room2);
        $this->plugin->persist($room3);

        $this->assertEquals([$room1, $room2, $room3], $this->plugin->getAll());

        $this->uuids[] = $uuid1;
        $this->uuids[] = $uuid2;
        $this->uuids[] = $uuid3;
    }
}