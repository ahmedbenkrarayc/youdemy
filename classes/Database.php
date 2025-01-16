<?php

require_once __DIR__.'/../env.php';
require_once __DIR__.'/../exceptions/EnvException.php';
require_once __DIR__.'/Logger.php';

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct(){
        try{
            $this->validate();
            $this->pdo = new PDO('mysql:host='.$GLOBALS['host'].';dbname='.$GLOBALS['db'].'; charset=utf8mb4', $GLOBALS['dbusername'], $GLOBALS['dbpassword']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }catch(EnvException $e){
            Logger::error_log($e->getMessage());
        }catch(PDOException $e) {
            Logger::error_log($e->getMessage());
        }
    }

    public static function getInstance(){
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection(){
        return $this->pdo;
    }

    private function validate(){
        if(!isset($GLOBALS['host']) || empty($GLOBALS['host'])){
            throw new EnvException('Host doesn\'t exist in env !');
        }

        if(!isset($GLOBALS['db']) || empty($GLOBALS['db'])){
            throw new EnvException('Database doesn\'t exist in env !');
        }

        if(!isset($GLOBALS['username']) || empty($GLOBALS['username'])){
            throw new EnvException('Username doesn\'t exist in env !');
        }

        
        if(!isset($GLOBALS['password'])){
            throw new EnvException('Password doesn\'t exist in env !');
        }
    }
}