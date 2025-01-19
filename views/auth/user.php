<?php
require_once __DIR__.'/../../classes/Etudiant.php';
if(isset($_SESSION['user_id'])){
    $user = new Etudiant($_SESSION['user_id'], null, null, null, null);
    $authUser = $user->getUser();
}else{
    $authUser = null;
}
?>