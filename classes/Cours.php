<?php 
require_once __DIR__.'/../exceptions/InputException.php';
require_once __DIR__.'/../interfaces/ICours.php';
require_once __DIR__.'/Database.php';
require_once __DIR__.'/CoursTag.php';

class Cours implements ICours{
    private $id;
    private $title;
    private $description;
    private $content;
    private $cover;
    private $type;
    private $createdAt;
    private $updatedAt;
    private $enseignant_id;
    private $category_id;
    private $errors = [];

    public function __construct($id, $title, $description, $content, $cover = null, $type = null, $category_id = null,$enseignant_id = null, $createdAt = null, $updatedAt = null){
        try{
            $this->setId($id);
            $this->setTitle($title);
            $this->setDescription($description);
            $this->setContent($content);
            $this->setCover($cover);
            $this->setType($type);
            $this->setCategoryId($category_id);
            $this->setEnseignantId($enseignant_id);
            $this->createdAt = $createdAt;
            $this->updatedAt = $updatedAt;

        }catch(InputException $e){
            array_push($this->errors, $e->getMessage());
        }
    }

    //getters
    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getContent(){
        return $this->content;
    }

    public function getType(){
        return $this->type;
    }

    public function getCreatedAt(){
        return $this->createdAt;
    }
 
    public function getUpdatedAt(){
        return $this->updatedAt;
    }

    public function getEnseigantId(){
        return $this->enseignant_id;
    }

    public function getCategoryId(){
        return $this->category_id;
    }

    public function getErrors(){
        return $this->errors;
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

    public function setTitle($title){
        if($title != null){
            if(!is_string($title))
                throw new InputException('Title must be a string !');

            if(strlen(trim($title)) < 5)
                throw new InputException('Title must contain at least 5 characters !');
        }
        $this->title = $title;
    }

    public function setDescription($description){
        if($description != null){
            if(!is_string($description))
                throw new InputException('Description must be a string !');

            if(strlen(trim($description)) < 200)
                throw new InputException('Description must contain at least 200 characters !');
        }
        $this->description = $description;
    }

    public function setContent($content){
        $this->content = $content;
    }

    public function setCover($cover){
        $this->cover = $cover;
    }

    public function setType($type){
        if($type != null)
            if($type != 'video' && $type != 'document')
                throw new InputException('Type can only be video or document !');
        $this->type = $type;
    }

    public function setEnseignantId($enseignant_id){
        if($enseignant_id != null){
            if(!filter_var($enseignant_id, FILTER_VALIDATE_INT))
                throw new InputException('Enseignant id must be a number !');

            if($enseignant_id < 1)
                throw new InputException('Enseignant id must be a positive number greater than 0 !');
        }

        $this->enseignant_id = $enseignant_id;
    }

    public function setCategoryId($category_id){
        if($category_id != null){
            if(!filter_var($category_id, FILTER_VALIDATE_INT))
                throw new InputException('Category id must be a number !');

            if($category_id < 1)
                throw new InputException('Category id must be a positive number greater than 0 !');
        }

        $this->category_id = $category_id;
    }

    //methods
    public function createCourse($tags){
        try{
            $nullvalue = false;
            if($this->title == null){
                array_push($this->errors, 'Title is required !');
                $nullvalue = true;
            }

            if($this->description == null){
                array_push($this->errors, 'Description is required !');
                $nullvalue = true;
            }

            if($this->content == null){
                array_push($this->errors, 'Content is required !');
                $nullvalue = true;
            }

            if($this->cover == null){
                array_push($this->errors, 'Cover is required !');
                $nullvalue = true;
            }

            if($this->type == null){
                array_push($this->errors, 'Type is required !');
                $nullvalue = true;
            }

            if($this->category_id == null){
                array_push($this->errors, 'Category is required !');
                $nullvalue = true;
            }

            if($this->enseignant_id == null){
                array_push($this->errors, 'Enseignant is required !');
                $nullvalue = true;
            }

            if($nullvalue)
                return false;

            $connection = Database::getInstance()->getConnection();
            $query = 'INSERT INTO cours(title, description, content, type, cover, category_id, enseignant_id) values(:title, :description, :content, :type, :cover, :category_id, :enseignant_id)';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':title', htmlspecialchars($this->title), PDO::PARAM_STR);
            $stmt->bindValue(':description', htmlspecialchars($this->description), PDO::PARAM_STR);
            $stmt->bindValue(':content', htmlspecialchars($this->content), PDO::PARAM_STR);
            $stmt->bindValue(':type', htmlspecialchars($this->type), PDO::PARAM_STR);
            $stmt->bindValue(':cover', htmlspecialchars($this->cover), PDO::PARAM_STR);
            $stmt->bindValue(':category_id', htmlspecialchars($this->category_id), PDO::PARAM_INT);
            $stmt->bindValue(':enseignant_id', htmlspecialchars($this->enseignant_id), PDO::PARAM_INT);
            if($stmt->execute()){
                $lastId = $connection->lastInsertId();
                foreach($tags as $item){
                    $tag = new CoursTag($lastId, $item);
                    $tag->attachCoursTag();
                }
                return true;
            }

            array_push($this->errors, 'Something went wrong !');
            return false;
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            array_push($this->errors, 'Something went wrong !');
            return false;
        }
    }

    public function updateCourse($tags){
        try{
            $nullvalue = false;

            if($this->id == null){
                array_push($this->errors, 'Id is required !');
                $nullvalue = true;
            }

            if($this->title == null){
                array_push($this->errors, 'Title is required !');
                $nullvalue = true;
            }

            if($this->description == null){
                array_push($this->errors, 'Description is required !');
                $nullvalue = true;
            }

            if($this->content == null){
                array_push($this->errors, 'Content is required !');
                $nullvalue = true;
            }

            if($this->cover == null){
                array_push($this->errors, 'Cover is required !');
                $nullvalue = true;
            }

            if($this->type == null){
                array_push($this->errors, 'Type is required !');
                $nullvalue = true;
            }

            if($this->category_id == null){
                array_push($this->errors, 'Category is required !');
                $nullvalue = true;
            }

            if($this->enseignant_id == null){
                array_push($this->errors, 'Enseignant is required !');
                $nullvalue = true;
            }

            if($nullvalue)
                return false;

            $connection = Database::getInstance()->getConnection();
            $query = 'UPDATE cours SET title = :title, description = :description, content = :content, cover = :cover, category_id = :category_id, enseignant_id = :enseignant_id, type = :type WHERE id = :id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':id', htmlspecialchars($this->id), PDO::PARAM_INT);
            $stmt->bindValue(':title', htmlspecialchars($this->title), PDO::PARAM_STR);
            $stmt->bindValue(':description', htmlspecialchars($this->description), PDO::PARAM_STR);
            $stmt->bindValue(':content', htmlspecialchars($this->content), PDO::PARAM_STR);
            $stmt->bindValue(':cover', htmlspecialchars($this->cover), PDO::PARAM_STR);
            $stmt->bindValue(':category_id', htmlspecialchars($this->category_id), PDO::PARAM_INT);
            $stmt->bindValue(':enseignant_id', htmlspecialchars($this->enseignant_id), PDO::PARAM_INT);
            $stmt->bindValue(':type', htmlspecialchars($this->type), PDO::PARAM_STR);
            if($stmt->execute()){
                $tag = new CoursTag($this->id, null);
                $tag->detachAllCoursTags();
                foreach($tags as $item){
                    $tag = new CoursTag($this->id, $item);
                    $tag->attachCoursTag();
                }
                return true;
            }

            array_push($this->errors, 'Something went wrong !');
            return false;
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            array_push($this->errors, 'Something went wrong !');
            return false;
        }
    }

    public function deleteCourse(){
        try{
            if($this->id == null){
                array_push($this->errors, 'Id is required !');
                $nullvalue = true;
            }

            $connection = Database::getInstance()->getConnection();
            $query = 'DELETE FROM cours WHERE id = :id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            if($stmt->execute()){
                return true;
            }

            array_push($this->errors, 'Something went wrong !');
            return false;
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            array_push($this->errors, 'Something went wrong !');
            return false;
        }
    }

    public function getAllCourse(){
        try{
            $connection = Database::getInstance()->getConnection();
            $query = 'SELECT a.*, u.fname AS teacher_fname, u.lname AS teacher_lname FROM cours a LEFT JOIN user u ON a.enseignant_id = u.id LEFT JOIN enseignant an ON a.enseignant_id = an.id WHERE an.id IS NULL OR an.suspended = 0;';
            $stmt = $connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            array_push($this->errors, 'Something went wrong !');
            return null;
        }
    }

    public function getCoursesByEnseignant(){
        try{
            $connection = Database::getInstance()->getConnection();
            $query = 'SELECT c.*, ct.name as category from cours c, category ct WHERE c.category_id = ct.id AND enseignant_id = :enseignant_id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':enseignant_id', $this->enseignant_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            array_push($this->errors, 'Something went wrong !');
            return null;
        }
    }

    public function getOneCourse(){
        try{
            if($this->id == null){
                $this->errors[] = 'Id is required !';
                return false;
            }

            $connection = Database::getInstance()->getConnection();
            $query = 'SELECT a.*, u.fname, u.lname, ct.name as category FROM cours a INNER JOIN category ct on ct.id = a.category_id INNER JOIN user u ON a.enseignant_id = u.id LEFT JOIN enseignant ad ON a.enseignant_id = ad.id WHERE (ad.id IS NULL OR ad.suspended = 0) AND a.id = :id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':id', htmlspecialchars($this->id), PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            array_push($this->errors, 'Something went wrong !');
            return null;
        }
    }

    public function getInscriptions(){
        try{
            if($this->id == null){
                $this->errors[] = 'Id is required !';
                return false;
            }

            $connection = Database::getInstance()->getConnection();
            $query = 'SELECT u.* from inscription i, user u where i.etudiant_id = u.id AND i.cours_id = :id';
            $stmt = $connection->prepare($query);
            $stmt->bindValue(':id', htmlspecialchars($this->id), PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e){
            Logger::error_log($e->getMessage());
            array_push($this->errors, 'Something went wrong !');
            return null;
        }
    }
}