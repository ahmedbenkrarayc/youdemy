<?php

require_once __DIR__.'/../classes/Category.php';

// $category = new Category(null, 'test');

// if($category->create()){
//     echo 'success';
// }else{
//     echo 'failed';
// }

$category = new Category(1, 'test1');
// if($category->update()){
//     echo 'success';
// }else{
//     echo 'failed';
// }

if($category->delete()){
    echo 'success';
}else{
    echo 'failed';
}