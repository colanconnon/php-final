<?php
require_once dirname(__FILE__)."/../Models/User.php";
require_once dirname(__FILE__)."/../Models/databaseglobals.php";
use PHPUnit\Framework\TestCase;
use Models\User as User;

class UserDatabaseTest extends TestCase
{
    public function setUp() {
        $connection = new PDO(CONNECTION_STRING, dbUsername, dbPassword);
        $statement = $connection->prepare('Delete From Users');
        $statement->execute();
        
    }
    public function testDatabaseOperations(){
        $faker = Faker\Factory::create();
        $this->assertTrue(empty(User::findAll()));
        $user = new User();
        $user->username = $faker->userName;
        $user->firstName = $faker->firstName;
        $user->lastName = $faker->lastName;
        $user->age= $faker->randomDigitNotNull;
        
        $user->save();
        $this->assertEquals(count(User::findAll()), 1);

        $user->firstName = $faker->userName;
        $user->save();
        $this->assertEquals(count(User::findAll()), 1);
        
        $user->destroy();
        $this->assertEquals(count(User::findAll()), 0);
    }
    
}