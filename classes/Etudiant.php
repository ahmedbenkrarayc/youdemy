<?php

require_once __DIR__.'/User.php';

class Etudiant extends User{
    protected $suspended;

    public function __construct($id, $fname, $lname, $email, $password, $suspended = null, $createdAt = null, $updatedAt = null){
        parent::__construct($id, $fname, $lname, $email, $password, 'etudiant', $createdAt, $updatedAt);
        try{
            $this->setSuspended($suspended);
        }catch(InputException $e){
            array_push($this->errors, $e->getMessage());
        }
    }

    public function getSuspended(){
        return $this->suspended;
    }

    public function setSuspended($suspended){
        if($suspended != null){
            if(!filter_var($suspended, FILTER_VALIDATE_INT))
                throw new InputException('Id must be a number !');

            if($suspended != 0 && $suspended != 1)
                throw new InputException('Suspended must be either 0 or 1 !');
        }

        $this->suspended = $suspended;
    }

    //methods
    public function updateProfile(){
        
    }

    public function register(){

    }

    public function suspendAccount(){

    }

    public function deleteAccount(){

    }
}