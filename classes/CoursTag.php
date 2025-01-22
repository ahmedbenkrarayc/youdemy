<?php 
require_once __DIR__.'/Database.php';
require_once __DIR__.'/../exceptions/InputException.php';

class CoursTag{
    private $cours_id;
    private $tag_id;
    private $errors = [];

    public function __construct($cours_id, $tag_id){
        try{
            $this->setCoursId($cours_id);
            $this->setTagId($tag_id);
        }catch(InputException $e){
            $this->errors[] = $e->getMessage();
        }
    }

    //getters
    public function getCoursId(){
        return $this->cours_id;
    }

    public function getTagId(){
        return $this->tag_id;
    }

    public function getErrors(){
        return $this->errors;
    }

    //setters
    public function setCoursId($cours_id){
        if($cours_id != null){
            if(!filter_var($cours_id, FILTER_VALIDATE_INT))
                throw new InputException('Cours id must be a number !');

            if($cours_id < 1)
                throw new InputException('Cours id must be a positive number greater than 0 !');
        }

        $this->cours_id = $cours_id;
    }

    public function setTagId($tag_id){
        if($tag_id != null){
            if(!filter_var($tag_id, FILTER_VALIDATE_INT))
                throw new InputException('Tag id must be a number !');

            if($tag_id < 1)
                throw new InputException('Tag id must be a positive number greater than 0 !');
        }

        $this->tag_id = $tag_id;
    }

    //methods
    public function attachCoursTag(){
        try{
            if($this->cours_id == null){
                array_push($this->errors, 'Cours id is required !');
                return false;
            }

            if($this->tag_id == null){
                array_push($this->errors, 'Tag id is required !');
                return false;
            }

            $connection =  Database::getInstance()->getConnection();
            $query = 'insert into courstag(cours_id, tag_id) values(:cours_id, :tag_id)';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':cours_id', htmlspecialchars($this->cours_id), PDO::PARAM_INT);
            $stmt->bindValue(':tag_id', htmlspecialchars($this->tag_id), PDO::PARAM_INT);
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

    public function detachCoursTag(){
        try{
            if($this->cours_id == null){
                $this->errors[] = 'Course id is required !';
                return false;
            }

            if($this->tag_id == null){
                $this->errors[] = 'Tag id is required !';
                return false;
            }

            $connection = Database::getInstance()->getConnection();
            $query = 'DELETE FROM courstag WHERE cours_id = :cours_id AND tag_id = :tag_id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':cours_id', htmlspecialchars($this->cours_id), PDO::PARAM_INT);
            $stmt->bindValue(':tag_id', htmlspecialchars($this->tag_id), PDO::PARAM_INT);
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

    public function detachAllCoursTags(){
        try{
            if($this->cours_id == null){
                array_push($this->errors, 'Course id is required !');
                return false;
            }
            $connection = Database::getInstance()->getConnection();
            $query = 'DELETE FROM courstag WHERE cours_id = :cours_id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':cours_id', htmlspecialchars($this->cours_id), PDO::PARAM_INT);
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

    public function tagsOfCours(){
        try{
            if($this->cours_id == null){
                $this->errors[] = 'Course id is required !';
                return false;
            }

            $connection = Database::getInstance()->getConnection();
            $query = 'SELECT t.* from tag t, courstag a WHERE a.tag_id = t.id and a.cours_id = :cours_id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':cours_id', htmlspecialchars($this->cours_id), PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return null;
        }
    }
}