<?php

namespace Models {

    use PDO;

    class User
    {
        public $id;
        public $username;
        public $firstName;
        public $lastName;
        public $age;
        private static $CONNECTION_STRING = 'mysql:host=127.0.0.1:33060;dbname=PhpFinal;charset=utf8';
        private static $dbUsername = 'homestead';
        private static $dbPassword = 'secret';
        private $errors = [];

        public static function find($id)
        {
            $connection = new PDO(self::$CONNECTION_STRING, self::$dbUsername, self::$dbPassword);
            $statement = $connection->prepare('Select * FROM Users WHERE id = :id');
            $statement->execute([
            ':id' => $id,
            ]);
            $results = $statement->fetchAll();
            if ($results != null) {
                $user = new self();
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

        public static function findAll()
        {
            $connection = new PDO(self::$CONNECTION_STRING, self::$dbUsername, self::$dbPassword);
            $statement = $connection->prepare('Select * FROM Users');
            $statement->execute();
            $results = $statement->fetchAll();
            $users = [];
            foreach ($results as $row) {
                $user = new self();
                $user->id = $row['id'];
                $user->username = $row['username'];
                $user->firstName = $row['firstname'];
                $user->lastName = $row['lastname'];
                $user->age = $row['age'];
                array_push($users, $user);
            }

            return $users;
        }

        public function save()
        {
            if ($this->validate()) {
                if (empty($this->id)) {
                    $connection = new PDO(self::$CONNECTION_STRING, self::$dbUsername, self::$dbPassword);
                    $statement = $connection->prepare('INSERT INTO Users
                    (username,
                    firstname,
                    lastname,
                    age)
                    VALUES
                    (:username,
                    :firstname,
                    :lastname,
                    :age)');
                    $statement->bindParam(':username', $this->username);
                    $statement->bindParam(':firstname', $this->firstName);
                    $statement->bindParam(':lastname', $this->lastName);
                    $statement->bindParam(':age', $this->age);

                    $statement->execute();
                    $this->id = $connection->lastInsertId();

                    return true;
                } else {
                    $connection = new PDO(self::$CONNECTION_STRING, self::$dbUsername, self::$dbPassword);
                    $statement = $connection->prepare('UPDATE Users
                    SET
                    username = :username,
                    firstname = :firstname ,
                    lastname = :lastname,
                    age = :age
                    WHERE id = :id');
                    $statement->bindParam(':username', $this->username);
                    $statement->bindParam(':firstname', $this->firstName);
                    $statement->bindParam(':lastname', $this->lastName);
                    $statement->bindParam(':age', $this->age);
                    $statement->bindParam(':id', $this->id);
                    $statement->execute();

                    return true;
                }
            } else {
                return false;
            }
        }

        public function destroy()
        {
            $connection = new PDO(self::$CONNECTION_STRING, self::$dbUsername, self::$dbPassword);
            $statement = $connection->prepare('DELETE FROM Users WHERE id = :id');
            $statement->bindParam(':id', $this->id);
            $statement->execute();
        }

        public function validate()
        {
            if (empty($this->username)) {
                array_push($this->errors, 'username is required.');
            }
            if (empty($this->firstName)) {
                array_push($this->errors, 'first name is required.');
            }
            if (empty($this->lastName)) {
                array_push($this->errors, 'last name is required.');
            }
            if (empty($this->age)) {
                array_push($this->errors, 'Age is required.');
            }
            if (!empty($this->errors)) {
                return false;
            }

            return true;
        }
        public function getErrors()
        {
            return $this->errors;
        }
    }
}
