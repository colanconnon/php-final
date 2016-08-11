<?php
require_once dirname(__FILE__)."/../../Models/User.php";
use Models\User as User;

class UserTest extends \Codeception\Test\Unit
{
    /**
    * @var \UnitTester
    */
    protected $tester;
    protected $faker;
    protected function _before()
    {
        $this->faker = Faker\Factory::create();
    }
    
    protected function _after()
    {
    }
    
    // tests
    public function testUserValidation()
    {
        $user = new User();
        
        $this->assertFalse($user->validate());
        
        $user->username = $this->faker->userName;
        $user->firstName = $this->faker->firstName;
        $user->lastName = $this->faker->lastName;
        $user->age= $this->faker->randomDigitNotNull;

        $this->assertTrue($user->validate());
    }
}
