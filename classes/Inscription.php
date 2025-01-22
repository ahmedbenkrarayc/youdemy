<?php 
require_once __DIR__.'/../exceptions/InputException.php';

class Inscription{
    private $cours_id;
    private $etudiant_id;
    private $errors;

    public function __construct($cours_id, $etudiant_id){
        try{
            $this->setCoursId($cours_id);
            $this->setEtudiantId($etudiant_id);
        }catch(InputException $e){
            array_push($this->errors, $e->getMessage());
        }
    }

    //getters
    public function getCoursId(){
        return $this->cours_id;
    }

    public function getEtudiantId(){
        return $this->etudiant_id;
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

    public function setEtudiantId($etudiant){
        if($etudiant != null){
            if(!filter_var($etudiant, FILTER_VALIDATE_INT))
                throw new InputException('Etudiant id must be a number !');

            if($etudiant < 1)
                throw new InputException('Etudiant id must be a positive number greater than 0 !');
        }

        $this->etudiant_id = $etudiant;
    }

    //methods
    public function attachEtudiantCours(){
        try{
            $nullable = false;

            if($this->cours_id == null){
                $this->errors[] = 'Cours id is required !';
                $nullable = true;
            }

            if($this->etudiant_id == null){
                $this->errors[] = 'Etudiant id is required !';
                $nullable = true;
            }

            if($nullable){
                return false;
            }

            $this->detachEtudiantCours();
            $connection =  Database::getInstance()->getConnection();
            $query = 'INSERT INTO inscription(cours_id, etudiant_id) VALUES(:cours_id, :etudiant_id)';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':cours_id', htmlspecialchars($this->cours_id), PDO::PARAM_INT);
            $stmt->bindValue(':etudiant_id', htmlspecialchars($this->etudiant_id), PDO::PARAM_INT);
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

    public function detachEtudiantCours(){
        try{
            $nullable = false;

            if($this->cours_id == null){
                $this->errors[] = 'Cours id is required !';
                $nullable = true;
            }

            if($this->etudiant_id == null){
                $this->errors[] = 'Etudiant id is required !';
                $nullable = true;
            }

            if($nullable){
                return false;
            }

            $connection =  Database::getInstance()->getConnection();
            $query = 'DELETE FROM inscription WHERE cours_id = :cours_id AND etudiant_id = :etudiant_id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':cours_id', htmlspecialchars($this->cours_id), PDO::PARAM_INT);
            $stmt->bindValue(':etudiant_id', htmlspecialchars($this->etudiant_id), PDO::PARAM_INT);
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

    public function getEtudiantCourses(){
        try{
            $nullable = false;

            if($this->etudiant_id == null){
                $this->errors[] = 'Etudiant id is required !';
                $nullable = true;
            }

            if($nullable){
                return false;
            }

            $connection =  Database::getInstance()->getConnection();
            $query = 'SELECT c.*, fname, lname FROM inscription i INNER JOIN cours c on i.cours_id = c.id INNER JOIN user u ON u.id = c.enseignant_id WHERE i.etudiant_id = :etudiant_id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':etudiant_id', htmlspecialchars($this->etudiant_id), PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return null;
        }
    }
}