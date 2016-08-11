<?php
/**Include the database globals so this class has access  **/
require_once dirname(__FILE__)."/databaseglobals.php";
/**Include the UserDatabaseRepository Interface  **/
require_once dirname(__FILE__)."/UserDatabaseRepository.php";
/** Include the user class  **/
require_once dirname(__FILE__)."/User.php";

use Models\User as User;
/**
* This class is an implementation of the UserDatabaseRepositoryClass

*/
class UserDatabaseRepositoryClass implements UserDatabaseRepository
{
    /** @type PDO the pdo connection that this class uses to access the database */
    private $connection;
    public function __construct()
    {
        $this->connection = new PDO(CONNECTION_STRING, dbUsername, dbPassword);
    }
    /**
    * Returns all the user objects.
    *
    *
    *
    * @return array $users An Array of all the users in the database
    */
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
    /**
    * Find a user by id in the database.
    *
    * @param int $id The id of the user you want to find from the database.
    *
    * @return User $user User object corresponding to the id passed in
    */
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
    
    /**
    * This method saves a user to the database if the id is set, if not then it updates the user.
    *
    * @param User $user A user object that you want to save or update in the database
    *
    * @return bool based on if the save worked.
    */
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
    /**
    * This method deletes an object from the database.
    *
    * @param int $id.
    *
    * @return void
    */
    public function Destroy($id)
    {
        $statement = $this->connection->prepare('DELETE FROM Users WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
    }
}
