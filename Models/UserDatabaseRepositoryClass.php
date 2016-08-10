<?php
require_once dirname(__FILE__)."/databaseglobals.php";
require_once dirname(__FILE__)."/UserDatabaseRepository.php";
require_once dirname(__FILE__)."/User.php";
use Models\User as User;

class UserDatabaseRepositoryClass implements UserDatabaseRepository
{
    private $connection;
    public function __construct()
    {
        $this->connection = new PDO(CONNECTION_STRING, dbUsername, dbPassword);
    }
    public function FindAll()
    {
        $statement = $this->connection->prepare('Select * FROM Users');
        $statement->execute();
        $results = $statement->fetchAll();
        $users = [];
        foreach ($results as $row) {
            $user = new User();
            $user->id = $row['id'];
            $user->username = $row['username'];
            $user->firstName = $row['firstname'];
            $user->lastName = $row['lastname'];
            $user->age = $row['age'];
            array_push($users, $user);
        }
        
        return $users;
    }
    
    public function Find($id)
    {
        $statement = $this->connection->prepare('Select * FROM Users WHERE id = :id');
        $statement->execute([
        ':id' => $id
        ]);
        $results = $statement->fetchAll();
        if ($results != null) {
            $user = new User();
            $user->id = $results[0]['id'];
            $user->username = $results[0]['username'];
            $user->firstName = $results[0]['firstname'];
            $user->lastName = $results[0]['lastname'];
            $user->age = $results[0]['age'];
            
            return $user;
        } else {
            return;
        }
    }
    
    public function Save(&$user)
    {
        if ($user->validate()) {
            if (empty($user->id)) {
                $statement = $this->connection->prepare('INSERT INTO Users
                (username,
                firstname,
                lastname,
                age)
                VALUES
                (:username,
                :firstname,
                :lastname,
                :age)');
                $statement->bindParam(':username', $user->username);
                $statement->bindParam(':firstname', $user->firstName);
                $statement->bindParam(':lastname', $user->lastName);
                $statement->bindParam(':age', $user->age);
                
                $statement->execute();
                $user->id = $this->connection->lastInsertId();
                
                return true;
            } else {
                $statement = $this->connection->prepare('UPDATE Users
                SET
                username = :username,
                firstname = :firstname ,
                lastname = :lastname,
                age = :age
                WHERE id = :id');
                $statement->bindParam(':username', $user->username);
                $statement->bindParam(':firstname', $user->firstName);
                $statement->bindParam(':lastname', $user->lastName);
                $statement->bindParam(':age', $user->age);
                $statement->bindParam(':id', $user->id);
                $statement->execute();
                
                return true;
            }
        } else {
            return false;
        }
    }
    
    public function Destroy($id)
    {
        $statement = $this->connection->prepare('DELETE FROM Users WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
    }
}
