<?php

require_once __DIR__.'/../classes/Enseignant.php';

$user = new Enseignant(null, 'ahmed', 'benkrara', 'ahmed.benkrara12@mail.com', 'ahmed123');

echo $user->register();
print_r($user->getErrors());