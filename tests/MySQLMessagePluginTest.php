<?php
namespace Test;


use Carbon\Carbon;
use Dotenv\Dotenv;
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
        $dotenv = new Dotenv(__DIR__ . '/../');
        $dotenv->load();

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
        $uuid1 = Uuid::uuid4()->toString();
        $uuid2 = Uuid::uuid4()->toString();
        $uuid3 = Uuid::uuid4()->toString();

        $message1 = new Message('test@that.com', '1234', 'message 1', Carbon::createFromDate('2010', '1', '5'), Carbon::createFromDate('2010', '1', '5'), $uuid1);
        $message2 = new Message('test@that.com', '1234', 'message 1', Carbon::createFromDate('2010', '1', '18'), Carbon::createFromDate('2010', '1', '18'), $uuid2);
        $message3 = new Message('test@that.com', '4313', 'message 1', Carbon::createFromDate('2010', '1', '5'), Carbon::createFromDate('2010', '1', '5'), $uuid3);

        $this->plugin->persist($message1);
        $this->plugin->persist($message2);
        $this->plugin->persist($message3);

        $this->assertEquals([], $this->plugin->getByDateRange('1234', Carbon::createFromDate('2010', '1', '2'), Carbon::createFromDate('2010', '1', '3')));
        $this->assertEquals([], $this->plugin->getByDateRange('4567', Carbon::createFromDate('2010', '1', '4'), Carbon::createFromDate('2010', '1', '7')));
        $this->assertEquals([$message1], $this->plugin->getByDateRange('1234', Carbon::createFromDate('2010', '1', '4'), Carbon::createFromDate('2010', '1', '7')));

        $this->assertEquals([$message1, $message2], $this->plugin->getByDateRange('1234', Carbon::createFromDate('2010', '1', '1'), Carbon::createFromDate('2010', '1', '30')));

        $this->uuids[] = $uuid1;
        $this->uuids[] = $uuid2;
        $this->uuids[] = $uuid3;
    }


}