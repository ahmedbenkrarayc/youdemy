<?php
session_start();
require_once './../classes/Cours.php';
require_once './../classes/User.php';
require_once './../classes/CoursTag.php';
require_once './../classes/Inscription.php';
require_once './auth/user.php';

if(!isset($_GET['id'])){
    header('Location: ./auth/login.php');
}

$article = new Cours($_GET['id'], null, null, null);
$currentCourse = $article->getOneCourse();

if(!$currentCourse){
    header('Location: ./../visitor/home.php');
}

$tagsCours = new CoursTag($_GET['id'] ,null);
$allTags = $tagsCours->tagsOfCours() ?? [];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['inscription'])){
        $inscription = new Inscription($_GET['id'], $_SESSION['user_id']);
        $inscription->attachEtudiantCours();
        // header('Location: ./etudiant/favorites.php');
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Course | Youdemy</title>
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
        
        <div class="page-wrapper">
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-cards">
                        <div class="col-md-12">
                            <div class="card">
                            <img style="height: 200px; object-fit: cover;" src="<?php echo $currentCourse['cover'] ?>" alt="">
                            <div class="card-body">
                                <div class="row g-2 align-items-center">
                                <div class="col">
                                    <h4 class="card-title m-0">
                                    <a href="#"><?php echo $currentCourse['fname'].' '.$currentCourse['lname'] ?></a>
                                    </h4>
                                    <div class="text-secondary">
                                        <?php echo $currentCourse['category'] ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <?php if($GLOBALS['authUser'] && $GLOBALS['authUser']['role'] == 'etudiant'): ?>
                                    <form style="display: inline;" action="" method="post">
                                        <button type="submit" name="inscription" class="btn btn-success">Inscription</button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cards" style="margin-top: 20px;">
                        <div class="col-lg-8">
                            <div class="card card-lg">
                                <div class="card-body">
                                    <?php echo htmlspecialchars_decode($currentCourse['description']) ?>
                                    <iframe style="width: 100%; min-height:500px; margin-top: 50px;" src="<?php echo $currentCourse['content'] ?>" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/scale -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 20l10 0" /><path d="M6 6l6 -1l6 1" /><path d="M12 3l0 17" /><path d="M9 12l-3 -6l-3 6a3 3 0 0 0 6 0" /><path d="M21 12l-3 -6l-3 6a3 3 0 0 0 6 0" /></svg>
                                    </div>
                                    <div>
                                        <h3 class="lh-1"><?php echo $currentCourse['title'] ?></h3>
                                    </div>
                                    </div>
                                    <div class="text-secondary mb-3">
                                        <div style="margin-bottom: 20px;">
                                            <?php foreach($allTags as $item): ?>
                                                <span class="badge bg-azure text-azure-fg"><?= $item['name'] ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
    <!-- Libs JS -->
    <script src="./../../dist/libs/list.js/dist/list.min.js?1692870487" defer></script>
    <!-- Tabler Core -->
    <script src="./../../dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./../../dist/js/demo.min.js?1692870487" defer></script>
  </body>
</html>