<?php

interface UserDatabaseRepository
{
    public function FindAll();
    public function Find($id);
    public function Save(&$user);
    public function Destroy($id);
}
