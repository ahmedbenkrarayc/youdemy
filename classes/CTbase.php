<?php
require_once __DIR__.'/Database.php';
require_once __DIR__.'/Logger.php';
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
            $this->errors[] = $e->getMessage();
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
        try{
            if($this->name == null){
                array_push($this->errors, 'Name is required !');
                return false;
            }
            $connection =  Database::getInstance()->getConnection();
            $query = 'INSERT INTO '.$this->getTableName().'(name) values(:name)';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':name', htmlspecialchars($this->name), PDO::PARAM_STR);
            if($stmt->execute()){
                return true;
            }

            array_push($this->errors, 'Something went wrong please try again later !');
            return false;
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            array_push($this->errors, 'Something went wrong !');
            return false;
        }
    }

    public function update(){
        try{
            $nullvalue = false;

            if($this->id == null){
                array_push($this->errors, 'Id is required !');
                $nullvalue = true;
            }

            if($this->name == null){
                array_push($this->errors, 'Name is required !');
                $nullvalue = true;
            }

            if($nullvalue)
                return false;

            $connection = Database::getInstance()->getConnection();
            $query = 'UPDATE '.$this->getTableName().' set name = :name where id = :id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':name', htmlspecialchars($this->name), PDO::PARAM_STR);
            $stmt->bindValue(':id', htmlspecialchars($this->id), PDO::PARAM_INT);
            if($stmt->execute()){
                return true;
            }

            $this->errors[] = 'Something went wrong !';
            return false;
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return false;
        }
    }

    public function delete(){
        try{
            if($this->id == null){
                $this->errors[] = 'Id is required !';
                return false;
            }

            $connection = Database::getInstance()->getConnection();
            $query = 'delete from '.$this->getTableName().' where id = :id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':id', htmlspecialchars($this->id), PDO::PARAM_INT);
            if($stmt->execute()){
                return true;
            }

            $this->errors[] = 'Something went wrong !';
            return false;
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return false;
        }
    }

    public function getAll(){
        try{
            $connection = Database::getInstance()->getConnection();
            $query = 'select * from '.$this->getTableName();
            $stmt = $connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            array_push($this->errors, 'Something went wrong !');
            return null;
        }
    }

    public function getOne(){

    }
}
