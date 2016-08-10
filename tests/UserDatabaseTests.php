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
        $this->setUpMocking();
    }
    public function setUpMocking(){
        $faker = Faker\Factory::create();
        $this->userDatabaseRepositoryMock = m::mock('UserDatabaseRepository');
        $user = new User();
        $user->username = $faker->userName;
        $user->firstName = $faker->firstName;
        $user->lastName = $faker->lastName;
        $user->age= $faker->randomDigitNotNull;
        $user->id = 1;
        $this->usersArray = [$user];
        $this->userDatabaseRepositoryMock->shouldReceive('FindAll')->andReturnUsing(function(){
            return $this->usersArray;
        });
        $this->userDatabaseRepositoryMock->shouldReceive('Find')->andReturnUsing(function($id) {
            foreach($this->usersArray as $row) {
                if($row->id == $id){
                    return $row;
                }
            }
            return null;
        });
        $this->userDatabaseRepositoryMock->shouldReceive('Save')->andReturnUsing(function($user){
            if($user->validate()) {
                if(empty($user->id)){
                    $user->id = 2;
                    array_push($this->usersArray, $user);
                }
                return true;
            } else {
                return false;
            }
        });
        $this->userDatabaseRepositoryMock->shouldReceive('Destroy')->andReturnUsing(function($id){
            foreach($this->usersArray as $row) {
                if($row->id == $id){
                    $userKey = array_search($row, $this->usersArray);
                    if($userKey != null) {
                        unset($this->usersArray[$userKey]);
                    }
                }
            }
            
            
        });
    }
    public function testDatabaseOperations(){
        $faker = Faker\Factory::create();
        $this->assertTrue(empty($this->userDatabaseRepo->FindAll()));
        $user = new User();
        $user->username = $faker->userName;
        $user->firstName = $faker->firstName;
        $user->lastName = $faker->lastName;
        $user->age= $faker->randomDigitNotNull;
        $this->userDatabaseRepo->Save($user);
        $this->assertEquals(count($this->userDatabaseRepo->FindAll()), 1);
        
        $user->firstName = $faker->userName;
        $this->userDatabaseRepo->Save($user);
        $this->assertEquals(count($this->userDatabaseRepo->FindAll()), 1);
        
        
        $this->userDatabaseRepo->Destroy($user->id);
        $this->assertEquals(count($this->userDatabaseRepo->FindAll()), 0);
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
        
        $this->assertEquals($this->userDatabaseRepositoryMock->Save($user), true);
        $this->assertEquals($this->userDatabaseRepositoryMock->Find($user->id)->firstName, $user->firstName);
        //update username
        $oldUsername = $user->username;
        $user->username = 'test';
        $this->assertEquals($this->userDatabaseRepositoryMock->Save($user), true);
        $this->assertNotEquals($this->userDatabaseRepositoryMock->Find($user->id), $oldUsername);
        $this->userDatabaseRepositoryMock->Destroy(2);
        $this->assertEquals(count($this->userDatabaseRepositoryMock->FindAll()), 1);
    }
    
}