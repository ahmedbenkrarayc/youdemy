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

    }
}