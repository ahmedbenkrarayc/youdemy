<?php
require_once __DIR__.'/Database.php';
require_once __DIR__.'/Logger.php';
require_once __DIR__.'/../exceptions/InputException.php';

abstract class User{
    protected $id;
    protected $fname;
    protected $lname;
    protected $email;
    protected $password;
    protected $role;
    protected $createdAt;
    protected $updatedAt;
    protected $errors = [];

    public function __construct($id, $fname, $lname, $email, $password, $role, $createdAt = null, $updatedAt = null){
        try{
            $this->setId($id);
            $this->setFname($fname);
            $this->setLname($lname);
            $this->setEmail($email);
            $this->setPassword($password);
            $this->setRole($role);
            $this->createdAt = $createdAt;
            $this->updatedAt = $updatedAt;
        }catch(InputException $e){
            $this->errors[] = $e->getMessage();
        }
    }

    //getters
    public function getId(){
        return $this->id;
    }

    public function getFname(){
        return $this->fname;
    }

    public function getLname(){
        return $this->lname;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getRole(){
        return $this->role;
    }

    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function getUpdatedAt(){
        return $this->updatedAt;
    }

    public function getErrors(){
        $errors = $this->errors;
        $this->errors = [];
        return $errors;
    }

    //setters
    public function setId($id){
        if($id != null){
            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new InputException('Id must be a number !');

            if($id < 1)
                throw new InputException('Id must be a positive number greater than 0 !');
        }
        $this->id = $id;
    }

    public function setFname($fname){
        if($fname != null){
            if(!is_string($fname))
                throw new InputException('First name must be a string !');

            if(strlen(trim($fname)) < 3)
                throw new InputException('First name must contain at least 3 characters !');
        }
        $this->fname = $fname;
    }

    public function setLname($lname){
        if($lname != null){
            if(!is_string($lname))
                throw new InputException('Last name must be a string !');

            if(strlen(trim($lname)) < 3)
                throw new InputException('Last name must be a string !');
        }
        $this->lname = $lname;
    }

    public function setEmail($email){
        if($email != null)
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                throw new InputException('Email isn\'t valid !');
        $this->email = $email;
    }

    public function setPassword($password){
        if($password != null)
            if(strlen($password) < 8)
                throw new InputException('Password must contain at least 8 characters !');
        $this->password = $password;
    }

    public function setRole($role){
        if($role != null)
            if($role != 'admin' && $role != 'enseignant' && $role != 'etudiant')
                throw new InputException('Role can only be admin, etudiant or enseignant !');
        $this->role = $role;
    }

    //methods

    public function login(){
        try{
            $nullvalue = false;
            if($this->email == null){
                $this->errors = 'Email is required !';
                $nullvalue = true;
            }
            
            if($this->password == null){
                $this->errors[] = 'Password is required !';
                $nullvalue = true;
            }

            if($nullvalue)
                return false;
    
            $connection = Database::getInstance()->getConnection();
            $query = 'SELECT id, role, password FROM user WHERE email = :email';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':email', htmlspecialchars($this->email), PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();

            if($user){
                //email found
                if(password_verify($this->password, $user['password'])){
                    //correct password
                    unset($stmt);
                    if($user['role'] == 'etudiant'){
                        $query = 'SELECT * from etudiant WHERE id = :id';
                        $stmt = $connection->prepare($query);
                        $stmt->bindValue(':id', $user['id'], PDO::PARAM_INT);
                        $stmt->execute();
                        $etudiant = $stmt->fetch();
                        if($etudiant){
                            if($etudiant['suspended'] == 1){
                                $this->errors[] = 'Your account is suspended at the moment !';
                                return false;
                            }
                        }else{
                            $this->errors[] = 'Something went wrong please try again later.';
                            return false;
                        }
                    }else if($user['role'] == 'enseignant'){
                        $query = 'SELECT * from enseignant WHERE id = :id';
                        $stmt = $connection->prepare($query);
                        $stmt->bindValue(':id', $user['id'], PDO::PARAM_INT);
                        $stmt->execute();
                        $enseignant = $stmt->fetch();
                        if($enseignant){
                            if($enseignant['suspended'] == 1){
                                $this->errors[] = 'Your account is suspended at the moment !';
                                return false;
                            }

                            if($enseignant['status'] == 'in review'){
                                $this->errors[] = 'Your account is still in review !';
                                return false;
                            }
                        }else{
                            $this->errors[] = 'Something went wrong please try again later.';
                            return false;
                        }
                    }

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_role'] = $user['role'];
                    return true;
                }else{
                    //wrong password
                    $this->errors[] = 'Wrong password !';
                    return false;
                }
            }else{
                //email notfound
                $this->errors[] = 'We have no user with this email !';
                return false;
            }
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return false;
        }
    }

    public function currentUser(){
        try{
            if($this->id == null){
                return false;
            }

            $connection = Database::getInstance()->getConnection();
            $query = 'SELECT * FROM user WHERE id = :id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':id', htmlspecialchars($this->id), PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch();
            if($user){
                return $user;
            }else{
                return null;
            }
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return null;
        }
    }

    public abstract function updateProfile();

    public static function logout(){
        session_unset();
        session_destroy();
        header('Location: ./login.php');
    }

    public static function verifyAuth($role = null){
        if(isset($_SESSION['user_id']) && isset($_SESSION['user_role'])){
            if($role != null){
                return $_SESSION['user_role'] == $role;
            }else{
                return true;
            }
        }
    
        return false;
    }

    public abstract function getAll();
}