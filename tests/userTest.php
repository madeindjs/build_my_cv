<?php
use PHPUnit\Framework\TestCase;





class UserTest extends TestCase
{
    /**
     * Test if User::getInstance return the same object
     * @covers \BuildMyCV\classes\User::getInstance()
     */
    public function testShouldBeSingleton()
    {
        $user_1 = \BuildMyCV\classes\User::getInstance() ;
        $user_2 = \BuildMyCV\classes\User::getInstance() ;
        $this->assertEquals($user_1, $user_2);
    }
    
    
    /**
     * Test if User::activities() return same quantity of activities that 
     * present in JSON file
     * @covers \BuildMyCV\classes\User::activities()
     */
    public function testActivitiesLength(){
        
        $user = \BuildMyCV\classes\User::getInstance() ;
        
        $String = file_get_contents("src/public/data.json");
        $array = json_decode($String, true);
        
        $total_activities = 0 ;
        
        foreach( $array['professional experience'] as $pExps ){
            $total_activities += count($pExps['activities']) ;
        }
        
        foreach( $array['personal experience'] as $pExps ){
            $total_activities += count($pExps['activities']) ;
        }
        
        $this->assertEquals(count($user->activities()), $total_activities);
    }
    
}
