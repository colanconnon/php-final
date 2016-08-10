<?php
require_once dirname(__FILE__)."/../Models/User.php";
use PHPUnit\Framework\TestCase;
use Models\User as User;

class UserTest extends TestCase
{
    public function testTest()
    {
        $user = new User();
        $faker = Faker\Factory::create();
        
        
        $user->age = $faker->randomDigitNotNull;
        $this->assertNotNull($user->age);
    }
    
    public function testValidation()
    {
        $faker = Faker\Factory::create();
        
        $errors = ['username is required.', 'first name is required.',
        'last name is required.', 'Age is required.' ];
        //create the array
        $user = new User();
        //check the model isn't valid
        $this->assertEquals($user->validate(), false);
        //check that all errors in the array
        $this->assertEquals(in_array($errors[0], $user->getErrors()), true);
        $this->assertEquals(in_array($errors[1], $user->getErrors()), true);
        $this->assertEquals(in_array($errors[2], $user->getErrors()), true);
        $this->assertEquals(in_array($errors[3], $user->getErrors()), true);
        //set the properties and make sure the error doesn't exist.
        $user->username = $faker->userName;
        $user->validate();
        $this->assertEquals(in_array($errors[0], $user->getErrors()), false);
        
        $user->firstName = $faker->firstName;
        $user->validate();
        $this->assertEquals(in_array($errors[1], $user->getErrors()), false);
        
        $user->lastName = $faker->lastName;
        $user->validate();
        $this->assertEquals(in_array($errors[2], $user->getErrors()), false);
        
        $user->age= $faker->randomDigitNotNull;
        $user->validate();
        $this->assertEquals(in_array($errors[3], $user->getErrors()), false);

        //assert that validation passes
        $this->assertEquals($user->validate(), true);
    }
}
