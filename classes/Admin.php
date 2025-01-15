<?php

require_once __DIR__.'/User.php';

class Admin extends User{
    public function __construct($id, $fname, $lname, $email, $password, $createdAt, $updatedAt){
        parent::__construct($id, $fname, $lname, $email, $password, 'admin', $createdAt, $updatedAt);
    }

    public function updateProfile(){
        
    }
}