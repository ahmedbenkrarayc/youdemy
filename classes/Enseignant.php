<?php
require_once __DIR__.'/Etudiant.php';

class Enseignant extends Etudiant{
    private $status;

    public function __construct($id, $fname, $lname, $email, $password, $status = null, $suspended = null, $createdAt = null, $updatedAt = null){
        try{
            parent::__construct($id, $fname, $lname, $email, $password, $suspended, $createdAt, $updatedAt);
            $this->setRole('enseignant');
            $this->setStatus($status);
        }catch(InputException $e){
            array_push($this->errors, $e->getMessage());
        }
    }

    public function getStatus(){
        return $this->suspended;
    }

    public function setStatus($status){
        if($status != null){
            if($status != 'confirmed' && $status != 'in review' && $status != 'rejected')
                throw new InputException('Status must only be accepted, in review or rejected !');
        }

        $this->status = $status;
    }

    //methods
    public function getTableName(){
        return 'enseignant';
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
                $query = 'INSERT INTO enseignant(id) VALUES(:id)';
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

    public function updateStatus(){
        try{
            $nullable = false;
            if($this->id == null){
                $this->errors[] = 'Id is required !';
                $nullable = true;
            }
            
            if($this->status == null){
                $this->errors[] = 'Status is required !';
                $nullable = true;
            }
            
            if($nullable)
                return false;

            $connection = Database::getInstance()->getConnection();
            $query = 'UPDATE enseignant SET status = :status WHERE id = :id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':id', $this->id,PDO::PARAM_INT);
            $stmt->bindValue(':status', htmlspecialchars($this->status),PDO::PARAM_STR);
            if($stmt->execute()){
                return true;
            }

            $this->errors[] = 'Something went wrong !';
            return false;
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return false;
        }
    }

    public function getAll(){
        try{
            $connection = Database::getInstance()->getConnection();
            $query = "select u.*, suspended, status from user u, enseignant e where u.id = e.id and role = 'enseignant'";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            $this->errors[] = 'Something went wrong !';
            return null;
        }
    }

    public function getRequests(){
        try{
            $connection = Database::getInstance()->getConnection();
            $query = "select u.*, status from user u, enseignant e where u.id = e.id and e.status = 'in review'";
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