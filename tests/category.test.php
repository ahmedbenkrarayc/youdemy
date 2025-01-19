<?php

require_once __DIR__.'/../classes/Category.php';

$category = new Category(null, 'test');

if($category->create()){
    echo 'success';
}else{
    echo 'failed';
}