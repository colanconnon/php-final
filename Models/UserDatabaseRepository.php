<?php

interface UserDatabaseRepository
{
    /**
     * Returns all the user objects.
     *
     * 
     *
     * @return array $users An Array of all the users in the database
     */
    public function FindAll();
    /**
     * Find a user by id in the database.
     *
     * @param int $id The id of the user you want to find from the database.
     *
     * @return User $user User object corresponding to the id passed in
     */
    public function Find($id);
    /**
     * This method saves a user to the database if the id is set, if not then it updates the user.
     *
     * @param User $user A user object that you want to save or update in the database
     *
     * @return bool based on if the save worked.
     */
    public function Save(&$user);
    /**
     * This method deletes an object from the database.
     *
     * @param int $id.
     *
     * @return void
     */
    public function Destroy($id);
}
