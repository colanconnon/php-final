<?php
require_once dirname(__FILE__)."/../Models/User.php";
require_once dirname(__FILE__)."/../Models/UserDatabaseRepositoryClass.php";
use Models\User as User;

class UserController
{
    //* @type UserDatabaseRepositoryClass Data access class */
    protected $userDatabaseRepo;
    public function __construct()
    {
        
        $this->userDatabaseRepo = new UserDatabaseRepositoryClass();
    }
    /*
    * Gets all the users in the database and renders a php file. 
    *
    *
    */
    public function show()
    {
        $users = $this->userDatabaseRepo->findAll();
        include_once '../Views/show.php';
    }

    /*
    * Get one user from the database
    */
    public function showOne($id)
    {
        $user = $this->userDatabaseRepo->find($id);
        include_once '../Views/showOne.php';
    }
    /*
    *   Show the insert form
    */ 
    public function showInsertForm()
    {
        $user = new User();
        include_once '../Views/insert.php';
    }
    /*
    * Handle the post of the insert form
    *
    *
    */
    public function insert($user)
    {
        if ($this->userDatabaseRepo->save($user)) {
            header('Location: /Controllers/UserController.php?route=showOne&id='.$user->id);
            exit();
        } else {
            $errors = $user->getErrors();
            include_once '../Views/insert.php';
        }
    }
    /*
    * Show the update form
    *
    */
    public function showUpdateForm($id)
    {
        $user = $this->userDatabaseRepo->find($id);
        if ($user != null) {
            include_once '../Views/update.php';
        } else {
            include_once '../Views/error.php';
        }
    }
    /*
    * Update the user in the data from a post
    *
    *
    */
    public function update($user)
    {
        if ($this->userDatabaseRepo->save($user)) {
            header('Location: /Controllers/UserController.php?route=showOne&id='.$user->id);
            exit();
        } else {
            $errors = $user->getErrors();
            include_once '../Views/update.php';
        }
    }

    /*
    * Show the delete form.
    */
    public function deleteForm($id)
    {
        $user = $this->userDatabaseRepo->find($id);
        if ($user != null) {
            include_once '../Views/delete.php';
        } else {
            include_once '../Views/error.php';
        }
    }

    /*
    * Handle a post and delete the item from the database.
    */
    public function delete($id)
    {
        $user = $this->userDatabaseRepo->find($id);
        if ($user != null) {
            $this->userDatabaseRepo->destroy($id);
            header('Location: /Controllers/UserController.php?route=show');
        }
    }
}

$userController = new UserController();
parse_str($_SERVER['QUERY_STRING']);
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $route == 'show') {
    $userController->show();
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $route == 'showOne') {
    $userController->showOne($id);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $route == 'insert') {
    $userController->showInsertForm();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $route == 'insert') {
    $user = new User();
    $user->firstName = $_POST['firstName'];
    $user->lastName = $_POST['lastName'];
    $user->age = $_POST['age'];
    $user->username = $_POST['username'];
    $userController->insert($user);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $route == 'update') {
    $userController->showUpdateForm($id);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $route == 'update') {
    $user = new User();
    $user->id = $_POST['Id'];
    $user->firstName = $_POST['firstName'];
    $user->lastName = $_POST['lastName'];
    $user->age = $_POST['age'];
    $user->username = $_POST['username'];
    if ($user->id != null) {
        $userController->update($user);
    } else {
        //todo: show error
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $route == 'delete') {
    $userController->deleteForm($id);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $route == 'delete') {
    $id = $_POST['id'];
    $userController->delete($id);
} else {
    include_once '../Views/error.php';
}
