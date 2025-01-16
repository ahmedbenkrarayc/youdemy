<?php

require_once __DIR__.'/Etudiant.php';

class Enseignant extends Etudiant{
    private $status;

    public function __construct($id, $fname, $lname, $email, $password, $status = null, $suspended = null, $createdAt = null, $updatedAt = null){
        parent::__construct($id, $fname, $lname, $email, $password, 'enseignant', $suspended, $createdAt, $updatedAt);
        try{
            $this->setStatus($status);
        }catch(InputException $e){
            array_push($this->errors, $e->getMessage());
        }
    }

    public function getStatus(){
        return $this->suspended;
    }

    public function setStatus($status){
        if($status != null){
            if($status != 'accepted' && $status != 'in review' && $status != 'rejected')
                throw new InputException('Status must only be accepted, in review or rejected !');
        }

        $this->status = $status;
    }

    //methods
    public function updateProfile(){
        
    }

    public function register(){

    }

    public function suspendAccount(){

    }
}