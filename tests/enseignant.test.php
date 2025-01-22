<?php

require_once __DIR__.'/../classes/Enseignant.php';

$user = new Enseignant(10, 'ahmed', 'benkrara', 'ahmed.benkrara12@mail.com', 'ahmed123');

// echo $user->register();
// print_r($user->getErrors());

// print_r($user->getAll());

print_r($user->studentCount());
print_r($user->coursCount());
print_r($user->todayInscriptionCount());
print_r($user->coursCountInscriptions());
