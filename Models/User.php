<?php

namespace Models {

    use PDO;

    require_once dirname(__FILE__)."/../Models/databaseglobals.php";

    class User
    {
        /** @type int primary key in the database*/
        public $id;
        /** @type string username of the user */
        public $username;
        /** @type string first name of the user */
        public $firstName;
        /** @type lastname of the user */
        public $lastName;
        /** @type int age of the user */
        public $age;

        /** @type array array of arrays */
        private $errors = [];

        /**
        * function to validate the properties of the odbc_fetch_object
        *
        *@return bool Returns whether or not the object is valid.
        */
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

        /**
        * @return the array of errors that the validate function generated
        */
        public function getErrors()
        {
            return $this->errors;
        }
    }
}
