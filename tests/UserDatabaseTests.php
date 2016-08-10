<?php
require_once dirname(__FILE__)."/../Models/User.php";
require_once dirname(__FILE__)."/../Models/databaseglobals.php";
require_once dirname(__FILE__)."/../Models/UserDatabaseRepositoryClass.php";
use PHPUnit\Framework\TestCase;
use Models\User as User;

class UserDatabaseTest extends TestCase
{
    private $userDatabaseRepo;
    public function setUp() {
        parent::setUp();
        $connection = new PDO(CONNECTION_STRING, dbUsername, dbPassword);
        $this->userDatabaseRepo = new UserDatabaseRepositoryClass();

        $statement = $connection->prepare('Delete From Users');
        $statement->execute();
        
    }
    public function testDatabaseOperations(){
        $faker = Faker\Factory::create();
        $this->assertTrue(empty($this->userDatabaseRepo->findAll()));
        $user = new User();
        $user->username = $faker->userName;
        $user->firstName = $faker->firstName;
        $user->lastName = $faker->lastName;
        $user->age= $faker->randomDigitNotNull;
        
        $this->userDatabaseRepo->save($user);
        $this->assertEquals(count($this->userDatabaseRepo->findAll()), 1);

        $user->firstName = $faker->userName;
        $this->userDatabaseRepo->save($user);
        $this->assertEquals(count($this->userDatabaseRepo->findAll()), 1);
        
        $this->userDatabaseRepo->destroy($user->id);
        $this->assertEquals(count($this->userDatabaseRepo->findAll()), 0);
    }
    
}