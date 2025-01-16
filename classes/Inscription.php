<?php 
require_once __DIR__.'/../exceptions/InputException.php';

class Inscription{
    private $cours_id;
    private $etudiant_id;
    private $errors;

    public function __construct($cours_id, $etudiant_id){
        try{
            $this->setCoursId($cours_id);
            $this->setTagId($etudiant_id);
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

        $this->etudiant = $etudiant;
    }

    //methods
    public function attachEtudiantCours(){

    }

    public function detachEtudiantCours(){

    }
}