<?php
require_once __DIR__.'/../exceptions/InputException.php';

abstract class User{
    protected $id;
    protected $fname;
    protected $lname;
    protected $email;
    protected $password;
    protected $role;
    protected $createdAt;
    protected $updatedAt;
    protected $errors = [];

    public function __construct($id, $fname, $lname, $email, $password, $role, $createdAt = null, $updatedAt = null){
        try{
            $this->setId($id);
            $this->setFname($fname);
            $this->setLname($lname);
            $this->setEmail($email);
            $this->setPassword($password);
            $this->setRole($role);
            $this->createdAt = $createdAt;
            $this->updatedAt = $updatedAt;
        }catch(InputException $e){
            array_push($this->errors, $e->getMessage());
        }
    }

    //getters
    public function getId(){
        return $this->id;
    }

    public function getFname(){
        return $this->fname;
    }

    public function getLname(){
        return $this->lname;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getRole(){
        return $this->role;
    }

    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function getUpdatedAt(){
        return $this->updatedAt;
    }

    public function getErrors(){
        $errors = $this->errors;
        $this->errors = [];
        return $errors;
    }

    //setters
    public function setId($id){
        if($id != null){
            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new InputException('Id must be a number !');

            if($id < 1)
                throw new InputException('Id must be a positive number greater than 0 !');
        }
        $this->id = $id;
    }

    public function setFname($fname){
        if($fname != null){
            if(!is_string($fname))
                throw new InputException('First name must be a string !');

            if(strlen(trim($fname)) < 3)
                throw new InputException('First name must contain at least 3 characters !');
        }
        $this->fname = $fname;
    }

    public function setLname($lname){
        if($lname != null){
            if(!is_string($lname))
                throw new InputException('Last name must be a string !');

            if(strlen(trim($lname)) < 3)
                throw new InputException('Last name must be a string !');
        }
        $this->lname = $lname;
    }

    public function setEmail($email){
        if($email != null)
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                throw new InputException('Email isn\'t valid !');
        $this->email = $email;
    }

    public function setPassword($password){
        if($password != null)
            if(strlen($password) < 8)
                throw new InputException('Password must contain at least 8 characters !');
        $this->password = $password;
    }

    public function setRole($role){
        if($role != null)
            if($role != 'admin' && $role != 'enseignant' && $role != 'etudiant')
                throw new InputException('Role can only be admin, visitor or author !');
        $this->role = $role;
    }

    //methods

    public function login(){

    }

    public function currentUser(){

    }

    public abstract function updateProfile();

    public static function logout(){

    }

    public static function verifyAuth($role = null){

    }
}