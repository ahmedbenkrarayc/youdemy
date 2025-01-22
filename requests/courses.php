<?php

require_once __DIR__.'/../classes/Cours.php';

$cours = new Cours(null, null, null, null);
$courses = $cours->getAllCourse();

if($courses !== null){
    echo json_encode([
        'success' => true,
        'data' => $courses
    ]);
}else{
    echo json_encode([
        'success' => false
    ]);
}