<?php
namespace Test;


use Domain\User;
use Storage\User\RedisUserPlugin;

class RedisUserPluginTest extends \Codeception\Test\Unit
{
    /**
     * @var \Test\
     */
    protected $tester;
    protected $plugin;
    protected $user;

    protected function _before()
    {
        $this->user = new User('parker@parkersmith.us', 'divsmith');
        $this->plugin = new RedisUserPlugin();
        $this->plugin->delete($this->user->email());
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $this->plugin->persist($this->user);
        $user = $this->plugin->getByEmail($this->user->email());

        $this->assertEquals($this->user->email(), $user->email());
        $this->assertEquals($this->user->alias(), $user->alias());
    }

    public function testUpdates()
    {
        $this->plugin->persist($this->user);
        $this->user->changeAlias('something else');
        $this->user->changeChatRoomID('17');
        $this->plugin->persist($this->user);

        $user = $this->plugin->getByEmail($this->user->email());

        $this->assertEquals('something else', $user->alias());
        $this->assertEquals('17', $user->chatRoomID());
    }

    public function testDelete()
    {
        $this->plugin->persist($this->user);
        $this->assertEquals(1, $this->plugin->delete($this->user->email()));
        $this->assertEquals(0, $this->plugin->delete($this->user->email()));
        $this->assertEquals(0, $this->plugin->delete('someother@email.com'));
    }
}