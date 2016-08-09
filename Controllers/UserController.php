<?php

require_once '../Models/User.php';
use Models\User as User;

class UserController
{
    public function __construct()
    {
    }
    public function show()
    {
        $users = User::findAll();
        include_once '../Views/show.php';
    }

    public function showOne($id)
    {
        $user = User::find($id);
        include_once '../Views/showOne.php';
    }
    public function showInsertForm()
    {
        $user = new User();
        include_once '../Views/insert.php';
    }
    public function insert($user)
    {
        if ($user->save()) {
            header('Location: /Controllers/UserController.php?route=showOne&id='.$user->id);
            exit();
        } else {
            $errors = $user->getErrors();
            include_once '../Views/insert.php';
        }
    }
    public function showUpdateForm($id)
    {
        $user = User::find($id);
        if ($user != null) {
            include_once '../Views/update.php';
        } else {
            include_once '../Views/error.php';
        }
    }
    public function update($user)
    {
        if ($user->save()) {
            header('Location: /Controllers/UserController.php?route=showOne&id='.$user->id);
            exit();
        } else {
            $errors = $user->getErrors();
            include_once '../Views/update.php';
        }
    }
    public function deleteForm($id)
    {
        $user = User::find($id);
        if ($user != null) {
            include_once '../Views/delete.php';
        } else {
            include_once '../Views/error.php';
        }
    }
    public function delete($id)
    {
        $user = User::find($id);
        if ($user != null) {
            $user->destroy();
            header('Location: /Controllers/UserController.php?route=showOne&id='.$user->id);
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
