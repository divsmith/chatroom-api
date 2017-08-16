<?php
namespace Test;


use Domain\Message;
use Ramsey\Uuid\Uuid;
use Storage\Plugins\Message\MySQLMessagePlugin;

class MySQLMessagePluginTest extends \Codeception\Test\Unit
{
    /**
     * @var \Test\
     */
    protected $tester;
    protected $plugin;
    protected $uuids;

    protected function _before()
    {
        $this->plugin = new MySQLMessagePlugin();
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
    public function testSomeFeature()
    {
        $email = 'parker@parkersmith.us';
        $chatroom = 'asdf1234';
        $message = 'This is the message for the chatroom';
        $created = new \DateTime('now');
        $updated = new \DateTime('now');
        $uuid = Uuid::uuid4()->toString();

        $message = new Message($email, $chatroom, $message, $created, $updated, $uuid);

        $this->assertTrue($this->plugin->persist($message));

        $this->assertEquals($message, $this->plugin->getByID($uuid));
        $this->assertTrue($this->plugin->delete($uuid));
        $this->assertNull($this->plugin->getByID($uuid));
    }

    public function testGetInvalidID()
    {
        $this->assertNull($this->plugin->getByID('asdfasdf'));
    }

    public function testGetByDateRange()
    {
        $message1 = new Message('test@that.com', '1234', 'message 1', new \DateTime())
    }


}