<?php
session_start();
require_once './../../classes/Inscription.php';
require_once './../auth/user.php';

if(!User::verifyAuth('etudiant')){
    header('Location: ./../auth/login.php');
}

$inscription = new Inscription(null, $GLOBALS['authUser']['id']);
$favorites = $inscription->getEtudiantCourses() ?? [];

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Favorites | Youdemy</title>
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
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                <div class="col">
                    <h2 class="page-title">
                        Favorite courses
                    </h2>
                </div>
                    <div class="row row-cards" style="margin-top:40px;">
                        <?php foreach($favorites as $item): ?>
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-sm">
                                    <a href="./../course.php?id=<?php echo $item['id'] ?>" class="d-block"><img src="<?php echo $item['cover'] ?>" class="card-img-top"></a>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center" style="justify-content: space-between;">
                                            <div>
                                                <div><?php echo $item['title'] ?></div>
                                                <div class="text-secondary"><?php echo $item['TYPE'] ?></div>
                                                <div class="text-secondary"><?php echo $item['fname'].' '.$item['lname'] ?></div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                </div>
            </div>
        <?php require_once './../../utils/__footer.php' ?>  
        </div>
    </div>
    <!-- Libs JS -->
    <script src="./../../dist/libs/list.js/dist/list.min.js?1692870487" defer></script>
    <!-- Tabler Core -->
    <script src="./../../dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./../../dist/js/demo.min.js?1692870487" defer></script>
  </body>
</html>