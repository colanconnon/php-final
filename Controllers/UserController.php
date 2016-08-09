<?php
require_once('../Models/User.php');

class UserController{
    
    function __construct() {
        
    }
    function show(){
        return User::findAll();
    }
    
    function showOne() {
        return User::find(1);
    }
    function insert($user){
       if($user->save()) {
           print("saved new user\n");
       } else {
           print("Error\n");
       }
    }
    function update($user){
        if($user->save()) {
            print("Updated user \n");
        } else {
            print("Error updating user \n");
        }
    }
    function delete($id) {
        $user = User::find($id);
        if($user != null) {
            $user->destroy();
        }
    }
}

$userController = new UserController();
print_r($userController->show());
print_r($userController->showOne(1));
// $user = new User();

// $user->firstName = "testfirst";
// $user->lastName = "testlast";
// $user->username = "testuser";
// $user->age = 123;
// $userController->insert($user);
$user = $userController->showOne(1);
$user->firstName = "Testing";
$userController->update($user);
$userController->delete(5);
?>