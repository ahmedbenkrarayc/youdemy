<?php 
session_start();
require_once './../../classes/Cours.php';
require_once './../../classes/User.php';
require_once './../auth/user.php';

if(!User::verifyAuth('enseignant')){
  header('Location: ./../auth/login.php');
}

$cours = new Cours(null, null, null, null, null, null, null, $_SESSION['user_id']);
$courses = $cours->getCoursesByEnseignant() ?? [] ;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['id'])){
    $cours = new Cours($_POST['id'], null, null, null, null, null, null, null);
    $cours->deleteCourse();
    header('Location: '.$_SERVER['PHP_SELF']);
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Categories | Youdemy</title>
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
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Courses list
                </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="card">
              <div class="card-body">
                <div id="table-default" class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th><button class="table-sort">#</button></th>
                        <th><button class="table-sort">Title</button></th>
                        <th><button class="table-sort">Type</button></th>
                        <th><button class="table-sort">Category</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Created at</button></th>
                        <th><button class="table-sort" data-sort="sort-type">Updated at</button></th>
                        <th><button class="table-sort" data-sort="sort-score">Actions</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      <?php foreach($courses as $index => $item ): ?>
                      <tr>
                        <td class="sort-name"><?php echo $index+1 ?></td>
                        <td class="sort-city"><?php echo $item['title'] ?></td>
                        <td class="sort-city"><?php echo $item['TYPE'] ?></td>
                        <td class="sort-city"><?php echo $item['category'] ?></td>
                        <td class="sort-type"><?php echo explode(' ',$item['createdAt'])[0] ?></td>
                        <td class="sort-score"><?php echo explode(' ', $item['updatedAt'])[0] ?></td>
                        <td class="sort-date">
                            <a href="./inscriptions.php?id=<?php echo $item['id'] ?>">inscriptions</a>
                            <a href="./editcourse.php?id=<?php echo $item['id'] ?>">edit</a>
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" style="display: inline;">
                              <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                              <button type="submit" style="color:red; background:transparent; border:none;">delete</button>
                            </form>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
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