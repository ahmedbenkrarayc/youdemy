<?php
require_once __DIR__.'/CTbase.php';

class Tag extends CTbase{
    public function __construct($id, $name, $createdAt = null, $updatedAt = null){
        parent::__construct($id, $name, $createdAt, $updatedAt);
    }

    //methods
    public function getTableName(){
        return "tag";
    }

    public function createMany($tags){
        try{
            foreach($tags as $tag){
                $this->setName(htmlspecialchars($tag));
                $this->create();
            }

            return true;
        }catch(Exception $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return false;
        }
    }
}