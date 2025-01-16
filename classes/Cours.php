<?php 
require_once __DIR__.'/../exceptions/InputException.php';
require_once __DIR__.'/../interfaces/ICours.php';

class Cours implements ICours{
    private $id;
    private $title;
    private $description;
    private $content;
    private $cover;
    private $type;
    private $createdAt;
    private $updatedAt;
    private $enseignant_id;
    private $errors = [];

    public function __construct($id, $title, $description, $content, $cover, $type, $enseignant_id, $createdAt = null, $updatedAt = null){
        try{
            $this->setId($id);
            $this->setTitle($title);
            $this->setDescription($description);
            $this->setContent($content);
            $this->setCover($cover);
            $this->setType($type);
            $this->setEnseignantId($enseignant_id);
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

    public function getTitle(){
        return $this->title;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getContent(){
        return $this->content;
    }

    public function getType(){
        return $this->type;
    }

    public function getCreatedAt(){
        return $this->createdAt;
    }
 
    public function getUpdatedAt(){
        return $this->updatedAt;
    }

    public function getEnseigantId(){
        return $this->enseignant_id;
    }

    public function getErrors(){
        return $this->errors;
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

    public function setTitle($title){
        if($title != null){
            if(!is_string($title))
                throw new InputException('Title must be a string !');

            if(strlen(trim($title)) < 5)
                throw new InputException('Title must contain at least 5 characters !');
        }
        $this->title = $title;
    }

    public function setDescription($description){
        if($description != null){
            if(!is_string($description))
                throw new InputException('Description must be a string !');

            if(strlen(trim($description)) < 200)
                throw new InputException('Description must contain at least 200 characters !');
        }
        $this->description = $description;
    }

    public function setContent($content){
        $this->content = $content;
    }

    public function setCover($cover){
        $this->cover = $cover;
    }

    public function setType($type){
        if($type != null)
            if($type != 'video' && $type != 'document')
                throw new InputException('Type can only be video or document !');
        $this->type = $type;
    }

    public function setEnseignantId($enseignant_id){
        if($enseignant_id != null){
            if(!filter_var($enseignant_id, FILTER_VALIDATE_INT))
                throw new InputException('Enseignant id must be a number !');

            if($enseignant_id < 1)
                throw new InputException('Enseignant id must be a positive number greater than 0 !');
        }

        $this->enseignant_id = $enseignant_id;
    }

    //methods
    public function createCourse(){

    }

    public function updateCourse(){

    }

    public function deleteCourse(){

    }

    public function getAllCourse(){

    }

    public function getOneCourse(){
        
    }
}