<?php 
require_once './../../classes/Category.php';
require_once './../../classes/Tag.php';
require_once './../../classes/Cours.php';
require_once './../../classes/User.php';
require_once './../../utils/csrf.php';
require_once './../auth/user.php';


if(!User::verifyAuth('enseignant')){
  header('Location: ./../auth/login.php');
}

if(!isset($_GET['id'])){
    header('Location: ./addarticle.php');
}

$category = new Category(null, null, null, null);
$categories = $category->getAll() ?? [] ;

$tag = new Tag(null, null, null, null);
$tags = $tag->getAll() ?? [] ;

$coursTag = new CoursTag($_GET['id'], null);
$currentTags = $coursTag->tagsOfCours() ?? [];

$cours = new Cours($_GET['id'], null, null, null, null, null, null, null, null, null);
$current = $cours->getOneCourse();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf_token']){
      if(!isset($_POST['tags'])){
        $errors[] = 'You should at least choose a tag.';
      }else{
        if(isset($_FILES['cover']) && $_FILES['cover']['error'] == 0){
          $picName = 'image'.time().rand(1000, 9999).'.'.pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
          move_uploaded_file($_FILES['cover']['tmp_name'], './../../assets/uploads/'.$picName);
          $cover = '/assets/uploads/'.$picName;
        }else{
          $cover = $current['cover'];
        }

        if(isset($_FILES['content']) && $_FILES['content']['error'] == 0){
            $docName = 'content'.time().rand(1000, 9999).'.'.pathinfo($_FILES['content']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['content']['tmp_name'], './../../assets/uploads/'.$docName);
            $doc = '/assets/uploads/'.$docName;
        }else{
            $doc = $current['content'];
        }

        $cours = new Cours($_GET['id'], $_POST['title'], $_POST['description'], $doc, $cover, $_POST['type'], $_POST['category_id'], $_SESSION['user_id'], null, null);
      
        $errors = $cours->getErrors();
        if(count($errors) == 0){
          try{
            if(!$cours->updateCourse($_POST['tags'])){
              $errors = $cours->getErrors();
            }else{
              header('Location: ./courses.php');
            }
          }catch(InputException $e){
            $errors[] = $e->getMessage();
          }
        }
      }
    }else{
      die('Invalid CSRF token');
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Update cours | Youdemy</title>
    <!-- CSS files -->
    <link href="./../../dist/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="./../../dist/css/tabler-flags.min.css?1692870487" rel="stylesheet"/>
    <link href="./../../dist/css/tabler-payments.min.css?1692870487" rel="stylesheet"/>
    <link href="./../../dist/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>
    <link href="./../../dist/css/demo.min.css?1692870487" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body >
    <script src="./../../dist/js/demo-theme.min.js?1692870487"></script>
    <div class="page">
        <!-- header here -->
        <?php require_once './../../utils/__header.php' ?>
        <div class="page-wrapper">
        <div style="margin-inline: auto; width: 80%; margin-top: 50px;">
            <div id="errors" class="alert alert-danger" role="alert" style="background: white; display: none;">
                <ul></ul>
            </div>
            <?php if(isset($errors) && count($errors) > 0): ?>
              <div class="alert alert-danger" role="alert" style="background: white;">
                  <ul>
                    <?php
                      foreach($errors as $error){
                        echo '<li>'.$error.'</li>';
                      }
                    ?>
                  </ul>
              </div>
            <?php endif; ?>
            <?php if(isset($success) && $success): ?>
              <div class="alert alert-success" role="alert" style="background: white;">Created successfully</div>
            <?php endif; ?>
            <form action="" method="POST" id="form" class="card" enctype="multipart/form-data">
                <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">
                <div class="card-header">
                  <h3 class="card-title">Update Cours</h3>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label required">Cover</label>
                    <div>
                      <input type="file" class="form-control" name="cover" id="cover" attrequired="true">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label required">Content</label>
                    <div>
                      <input type="file" class="form-control" name="content" id="content" accept=".pdf, .doc, .docx, .txt, .mp4, .avi, .mkv, .mov, .wmv" attrequired="true">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label required">Title</label>
                    <div>
                      <input type="text" class="form-control" value="<?php echo $current['title'] ?>" placeholder="Enter title" name="title" id="title">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label required">Category</label>
                    <div>
                      <select class="form-select" name="category_id" id="category">
                        <?php foreach($categories as $category): ?>
                          <option value="<?php echo $category['id'] ?>" <?php echo $current['category_id'] == $category['id'] ? 'selected' : '' ?>><?php echo $category['name'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label required">Cours type</label>
                    <div>
                      <select class="form-select" name="type" id="type">
                        <option value="video" <?php echo $current['TYPE'] == 'video' ? 'selected' : '' ?>>video</option>
                        <option value="document" <?php echo $current['TYPE'] == 'document' ? 'selected' : '' ?>>document</option>
                      </select>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label required">Tags</label>
                    <div>
                        <select class="form-select" name="tags[]" id="tags" multiple required>
                        <?php foreach ($tags as $item): ?>
                            <?php 
                            $exists = false;
                            foreach ($currentTags as $currentTag) {
                                if ($currentTag['id'] == $item['id']) {
                                    $exists = true;
                                    break;
                                }
                            }
                            ?>
                            <option value="<?php echo $item['id']; ?>" <?php echo $exists ? 'selected' : ''; ?>>
                            <?php echo $item['name']; ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label required">Description</label>
                    <div>
                      <textarea class="form-control" placeholder="Enter description" name="description" id="description"><?php echo $current['description'] ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-end">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
        </div>
        <?php require_once './../../utils/__footer.php' ?>
      </div>
    </div>
    <script src="./../../assets/js/validation.js"></script>
    <script src="./../../assets/js/course/addcourse.js"></script>
    <!-- Libs JS -->
    <script src="./../../dist/libs/list.js/dist/list.min.js?1692870487" defer></script>
    <script src="./../../dist/libs/tinymce/tinymce.min.js?1692870487" defer></script>
    <!-- Tabler Core -->
    <script src="./../../dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./../../dist/js/demo.min.js?1692870487" defer></script>
   
  </body>
</html>