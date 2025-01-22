<?php 
require_once './../../classes/Etudiant.php';
require_once './../../utils/csrf.php';
require_once './user.php';


if(User::verifyAuth()){
  if($_SESSION['user_role'] == 'admin'){
    header('Location: ./../admin/statistics.php');
  }else if($_SESSION['user_role'] == 'enseignant'){
    header('Location: ./../teacher/statistics.php');
  }else{
    header('Location: ./../etudiant/favorite.php');
  }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf_token']){
    $user = new Etudiant(null, null, null, $_POST['email'], $_POST['password']);

    $errors = $user->getErrors();
    if(count($errors) == 0){
      try{
        if(!$user->login()){
          $errors = $user->getErrors();
        }else{
          header('Location: '.$_SERVER['PHP_SELF']);
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
    <title>Sign in | Youdemy</title>
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
  <body  class=" d-flex flex-column">
    <script src="./../../dist/js/demo-theme.min.js?1692870487"></script>
    <?php require_once './../../utils/__header.php' ?>
    <div class="page page-center">
      <div class="container container-tight py-4">
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
        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Login to your account</h2>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="form">
              <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">
              <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="your@email.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
              </div>
              <div class="mb-2">
                <label class="form-label">Password</label>
                <div class="input-group input-group-flat">
                  <input type="password" id="password" name="password" class="form-control"  placeholder="Your password">
                </div>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
              </div>
            </form>
          </div>
        </div>
        <div class="text-center text-secondary mt-3">
          Don't have account yet? <a href="./signup.php" tabindex="-1">Sign up</a>
        </div>
      </div>
      <?php require_once './../../utils/__footer.php' ?>
    </div>
    <script src="./../../assets/js/validation.js"></script>
    <script src="./../../assets/js/auth/login.js"></script>
    <!-- Tabler Core -->
    <script src="./../../dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./../../dist/js/demo.min.js?1692870487" defer></script>
  </body>
</html>