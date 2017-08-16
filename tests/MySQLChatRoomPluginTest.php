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

    protected function _before()
    {
        $this->plugin = new MySQLChatRoomPlugin();
    }

    protected function _after()
    {
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
    }

    public function testGetWithInvalidID()
    {
        $this->assertNull($this->plugin->getByID('asdfasdf'));
    }
}