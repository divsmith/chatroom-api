<?php
namespace Test;


use Domain\Exceptions\InvalidEmailException;
use Domain\User;
use Ramsey\Uuid\Uuid;

class UserTest extends \Codeception\Test\Unit
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
        $email = 'parker@parkersmith.us';
        $alias = 'divsmith';
        $chatRoomID = '17';

        $user = new User($email, $alias, $chatRoomID);

        $this->assertEquals($user->email(), $email);
        $this->assertEquals($user->alias(), $alias);
        $this->assertEquals($chatRoomID, $user->chatRoomID());
    }

    public function testDefaultChatRoomID()
    {
        $user = new User('parker@parkersmith.us', 'divsmith');

        $this->assertNull($user->chatRoomID());
    }

    public function testInvalidEmail()
    {
        $email = 'bogus';
        $alias = 'divsmith';

        $this->expectException(InvalidEmailException::class);

        $user = new User($email, $alias);
    }

    public function testUpdateAlias()
    {
        $email = 'parker@parkersmith.us';
        $alias = 'divsmith';

        $user = new User($email, $alias);
        $user->changeAlias('something else');

        $this->assertEquals('something else', $user->alias());
    }

}