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

        $user = new User($email, $alias);

        $this->assertEquals($user->email(), $email);
        $this->assertEquals($user->alias(), $alias);
    }

    public function testInvalidEmail()
    {
        $email = 'bogus';
        $alias = 'divsmith';

        $this->expectException(InvalidEmailException::class);

        $user = new User($email, $alias);
    }

}