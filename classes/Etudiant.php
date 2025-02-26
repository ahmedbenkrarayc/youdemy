<?php

require_once __DIR__.'/User.php';

class Etudiant extends User{
    protected $suspended;

    public function __construct($id, $fname, $lname, $email, $password, $suspended = null, $createdAt = null, $updatedAt = null){
        parent::__construct($id, $fname, $lname, $email, $password, 'etudiant', $createdAt, $updatedAt);
        try{
            $this->setSuspended($suspended);
        }catch(InputException $e){
            array_push($this->errors, $e->getMessage());
        }
    }

    public function getSuspended(){
        return $this->suspended;
    }

    public function setSuspended($suspended){
        if($suspended != null){
            if(!filter_var($suspended, FILTER_VALIDATE_INT))
                throw new InputException('Id must be a number !');

            if($suspended != 0 && $suspended != 1)
                throw new InputException('Suspended must be either 0 or 1 !');
        }

        $this->suspended = $suspended;
    }

    //methods
    public function getTableName(){
        return 'etudiant';
    }

    public function updateProfile(){
        try{
            $nullvalue = false;
            if($this->id == null){
                array_push($this->errors, 'Id is required !');
                $nullvalue = true;
            }

            if($this->fname == null){
                array_push($this->errors, 'First name is required !');
                $nullvalue = true;
            }

            if($this->lname == null){
                array_push($this->errors, 'Last name is required !');
                $nullvalue = true;
            }

            if($nullvalue)
                return false;

            $connection = Database::getInstance()->getConnection();
            $query = 'UPDATE user SET fname = :fname, lname = :lname '; 
            if($this->password != null)
                $query .= 'password = :password ';
            $query .= ' WHERE id = :id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':id', htmlspecialchars($this->id), PDO::PARAM_INT);
            $stmt->bindValue(':fname', htmlspecialchars($this->fname), PDO::PARAM_STR);
            $stmt->bindValue(':lname', htmlspecialchars($this->lname), PDO::PARAM_STR);
            if($this->password != null){
                $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
            }

            if($stmt->execute()){
                if($this->suspended === null){
                    return true;
                }else{
                    unset($stmt);
                    $query = 'UPDATE '.$this->getTableName().' SET suspended = :suspended WHERE id = :id';
                    $stmt = $connection->prepare($query);
                    $stmt->bindValue(':id', htmlspecialchars($this->id), PDO::PARAM_INT);
                    $stmt->bindValue(':suspended', $this->suspended, PDO::PARAM_INT);
                    if($stmt->execute()){
                        return true;
                    }
                }
            }

            array_push($this->errors, 'Something went wrong !');
            return false;
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            array_push($this->errors, 'Something went wrong !');
            return false;
        }
    }

    public function register(){
        try{
            $nullvalue = false;
            if($this->getFname() == null){
                $this->errors[] = 'First name is required !';
                $nullvalue = true;
            }

            if($this->getLname() == null){
                $this->errors[] = 'Last name is required !';
                $nullvalue = true;
            }

            if($this->getEmail() == null){
                $this->errors[] = 'Email is required !';
                $nullvalue = true;
            }
            
            if($this->getPassword() == null){
                $this->errors[] = 'Password is required !';
                $nullvalue = true;
            }

            if($this->getRole() == null){
                $this->errors[] = 'Role is required !';
                $nullvalue = true;
            }

            if($nullvalue)
                return false;

            $connection = Database::getInstance()->getConnection();
            $emailCheckQuery = 'SELECT COUNT(*) FROM user WHERE email = :email';
            $emailCheckStmt = $connection->prepare($emailCheckQuery);
            $emailCheckStmt->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
            $emailCheckStmt->execute();
            if ($emailCheckStmt->fetchColumn() > 0) {
                $this->errors[] = 'Email already exists!';
                return false;
            }

            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
            
            $query = 'INSERT INTO user(fname, lname, email, password, role) VALUES(:fname, :lname, :email, :password, :role)';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':fname', htmlspecialchars($this->fname), PDO::PARAM_STR);
            $stmt->bindValue(':lname', htmlspecialchars($this->lname), PDO::PARAM_STR);
            $stmt->bindValue(':email', htmlspecialchars($this->email), PDO::PARAM_STR);
            $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindValue(':role', htmlspecialchars($this->role), PDO::PARAM_STR);
            if($stmt->execute()){
                $id = $connection->lastInsertId();
                $query = 'INSERT INTO etudiant(id) VALUES(:id)';
                unset($stmt);
                $stmt = $connection->prepare($query);
                $stmt->bindValue(':id', $id, PDO::PARAM_STR);
                if($stmt->execute()){
                    return true;
                }

            }

            $this->errors[] = 'Something went wrong !';
            return false;
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return false;
        }
    }

    public function deleteAccount(){
        try{
            $nullvalue = false;
            if($this->id == null){
                $this->errors[] = 'Id is required !';
                $nullvalue = true;
            }

            if($nullvalue)
                return false;

            $connection = Database::getInstance()->getConnection();
            $query = 'DELETE FROM user WHERE id = :id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':id', $this->id);
            if($stmt->execute()){
                return true;
            }

            $this->errors[] = 'Something went wrong !';
            return false;
        }catch(InputException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return false;
        }
    }

    public function getAll(){
        try{
            $connection = Database::getInstance()->getConnection();
            $query = "select u.*, suspended from user u, etudiant e where u.id = e.id and role = 'etudiant'";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return null;
        }
    }
}