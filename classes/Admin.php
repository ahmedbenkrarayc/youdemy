<?php

require_once __DIR__.'/User.php';

class Admin extends User{
    public function __construct($id, $fname, $lname, $email, $password, $createdAt = null, $updatedAt = null){
        parent::__construct($id, $fname, $lname, $email, $password, 'admin', $createdAt, $updatedAt);
    }

    public function updateProfile(){
        
    }

    public function getAll(){}

    //statistics

    public function coursCount(){
        try{
            $connection = Database::getInstance()->getConnection();
            $query = "SELECT COUNT(*) FROM cours";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchColumn();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return null;
        }
    }

    public function etudiantCount(){
        try{
            $connection = Database::getInstance()->getConnection();
            $query = "SELECT COUNT(*) FROM etudiant";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchColumn();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return null;
        }
    }

    public function enseignantCount(){
        try{
            $connection = Database::getInstance()->getConnection();
            $query = "SELECT COUNT(*) FROM enseignant";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchColumn();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return null;
        }
    }

    public function coursPlusEtudiant(){
        try{
            $connection = Database::getInstance()->getConnection();
            $query = "SELECT COUNT(*) AS nombre, title FROM inscription i, cours c WHERE i.cours_id = c.id GROUP BY c.id ORDER BY nombre DESC LIMIT 1;";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            return $stmt->fetch();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return null;
        }
    }

    public function top3Enseignant(){
        try{
            $connection = Database::getInstance()->getConnection();
            $query = "SELECT COUNT(*) AS nombre, fname, lname FROM inscription i, cours c, user e WHERE i.cours_id = c.id AND c.enseignant_id = e.id GROUP BY e.id ORDER BY nombre DESC LIMIT 3";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return null;
        }
    }

    public function reparationParCategory(){
        try{
            $connection = Database::getInstance()->getConnection();
            $query = "SELECT COUNT(cr.id) AS nombre, ct.name FROM category ct LEFT JOIN cours cr ON ct.id = cr.category_id GROUP BY ct.id";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return null;
        }
    }

}