<?php 
require_once './../../classes/Category.php';
require_once './../../utils/csrf.php';
require_once './../auth/user.php';

if(!User::verifyAuth('admin')){
  header('Location: ./../auth/login.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf_token']){
    $category = new Category(null, $_POST['name']);
  
    $errors = $category->getErrors();
    if(count($errors) == 0){
      try{
        if(!$category->create()){
          $errors = $category->getErrors();
        }else{
          $success = true;
        }
      }catch(InputException $e){
        $errors[] = $e->getMessage();
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
    <title>Create Category | Youdemy</title>
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
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="card" id="form">
                <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">
                <div class="card-header">
                  <h3 class="card-title">Create category</h3>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label required">Category name</label>
                    <div>
                      <input type="text" class="form-control" placeholder="Enter category" name="name" id="name">
                    </div>
                  </div>
                </div>
                <div class="card-footer text-end">
                  <button type="submit" class="btn btn-primary">Create</button>
                </div>
              </form>
            </div>
        </div>
        <?php require_once './../../utils/__footer.php' ?>
      </div>
    </div>
    <script src="./../../assets/js/validation.js"></script>
    <script src="./../../assets/js/category/addcategory.js"></script>
    <!-- Libs JS -->
    <script src="./../../dist/libs/list.js/dist/list.min.js?1692870487" defer></script>
    <!-- Tabler Core -->
    <script src="./../../dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./../../dist/js/demo.min.js?1692870487" defer></script>
  </body>
</html>