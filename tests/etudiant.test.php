<?php

require_once __DIR__.'/../classes/Etudiant.php';

$user = new Etudiant(null, 'ahmed', 'benkrara', 'ahmed.benkrara12@mail.com', 'ahmed123');

// echo $user->register();
// print_r($user->getErrors());

print_r($user->getAll());