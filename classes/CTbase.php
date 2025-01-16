<?php
require_once __DIR__.'/../exceptions/InputException.php';

abstract class CTbase{
    protected $id;
    protected $name;
    protected $createdAt;
    protected $updatedAt;
    protected $errors = [];

    public function __construct($id, $name, $createdAt = null, $updatedAt = null){
        try{
            $this->setId($id);
            $this->setName($name);
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

    public function getName(){
        return $this->name;
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

    public function setName($name){
        if($name != null){
            if(!is_string($name))
                throw new InputException('Name must be a string !');

            if(strlen(trim($name)) < 3)
                throw new InputException('Name must contain at least 3 characters !');
        }
        $this->name = $name;
    }

    //methods
    public abstract function getTableName();

    public function create(){

    }

    public function update(){

    }

    public function delete(){

    }

    public function getAll(){

    }

    public function getOne(){

    }
}
