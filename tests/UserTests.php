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
}