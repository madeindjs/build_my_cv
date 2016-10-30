<?php
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * Test if User::getInstance return the same object
     */
    public function testShouldBeSingleton()
    {
        $user_1 = \BuildMyCV\classes\User::getInstance() ;
        $user_2 = \BuildMyCV\classes\User::getInstance() ;
        $this->assertEquals($user_1, $user_2);
    }
}
