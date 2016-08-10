<?php
require_once dirname(__FILE__)."/../Models/User.php";
require_once dirname(__FILE__)."/../Models/databaseglobals.php";
require_once dirname(__FILE__)."/../Models/UserDatabaseRepositoryClass.php";
use PHPUnit\Framework\TestCase;
use Models\User as User;
use \Mockery as m;

class UserDatabaseTest extends TestCase
{
    private $userDatabaseRepo;
    private $userDatabaseRepositoryMock;
    public function setUp() {
        parent::setUp();
        $connection = new PDO(CONNECTION_STRING, dbUsername, dbPassword);
        $this->userDatabaseRepo = new UserDatabaseRepositoryClass();
        
        $statement = $connection->prepare('Delete From Users');
        $statement->execute();
        
        $faker = Faker\Factory::create();
        $this->userDatabaseRepositoryMock = m::mock('UserDatabaseRepository');
        $user = new User();
        $user->username = $faker->userName;
        $user->firstName = $faker->firstName;
        $user->lastName = $faker->lastName;
        $user->age= $faker->randomDigitNotNull;
        $user->id = 1;
        
        $user = new User();
        $user->username = $faker->userName;
        $user->firstName = $faker->firstName;
        $user->lastName = $faker->lastName;
        $user->age= $faker->randomDigitNotNull;
        $user->id = 1;
        $usersArray = [$user];
        $this->userDatabaseRepositoryMock->shouldReceive('FindAll')->andReturn($usersArray);
        $this->userDatabaseRepositoryMock->shouldReceive('Find')->andReturn($user);
        $this->userDatabaseRepositoryMock->shouldReceive('Save')->andReturnUsing(function($user){
            if($user->validate()) {
                if(empty($user->id)){
                    $user->id = 1;
                }
                return true;
            } else {
                return false;
            }
        });
        
        
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
    
    public function testMockDatabaseOperations() {
        $this->assertEquals(count($this->userDatabaseRepositoryMock->FindAll()), 1);
        $this->assertEquals($this->userDatabaseRepositoryMock->Find(1)->id, 1);
        $faker = Faker\Factory::create();
        
        $user = new User();
        $user->username = $faker->userName;
        $user->firstName = $faker->firstName;
        $user->lastName = $faker->lastName;
        $user->age= $faker->randomDigitNotNull;
        
        print_r($this->userDatabaseRepositoryMock->Save($user));
    }
    
}