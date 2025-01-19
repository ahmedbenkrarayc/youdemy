<?php
require_once './../../classes/User.php';
session_start();

if(!User::verifyAuth()){
    header('Location: ./../login.php');
}

User::logout();