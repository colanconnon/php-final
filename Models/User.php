<?php

namespace Models {

    use PDO;

    require_once dirname(__FILE__)."/../Models/databaseglobals.php";

    class User
    {
        public $id;
        public $username;
        public $firstName;
        public $lastName;
        public $age;

        private $errors = [];


        public function validate()
        {
            $this->errors = [];
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
