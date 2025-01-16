<?php 
require_once __DIR__.'/../exceptions/InputException.php';

class CoursTag{
    private $cours_id;
    private $tag_id;
    private $errors;

    public function __construct($cours_id, $tag_id){
        try{
            $this->setCoursId($cours_id);
            $this->setTagId($tag_id);
        }catch(InputException $e){
            array_push($this->errors, $e->getMessage());
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

    }

    public function detachCoursTag(){

    }

    public function detachAllCoursTags(){
        
    }
}