<?php 
session_start();
require_once './../../classes/Cours.php';
require_once './../../classes/User.php';
require_once './../auth/user.php';

if(!User::verifyAuth('enseignant')){
  header('Location: ./../auth/login.php');
}

if(!isset($_GET['id'])){
    header('Location: ./courses.php');
}

$cours = new Cours($_GET['id'], null, null, null, null, null, null, $_SESSION['user_id']);
$inscriptions = $cours->getInscriptions() ?? [] ;

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Course inscriptions | Youdemy</title>
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
                  Inscription list
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
                        <th><button class="table-sort">First name</button></th>
                        <th><button class="table-sort">Last name</button></th>
                        <th><button class="table-sort">Email</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Created at</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      <?php foreach($inscriptions as $index => $item ): ?>
                      <tr>
                        <td class="sort-name"><?php echo $index+1 ?></td>
                        <td class="sort-city"><?php echo $item['fname'] ?></td>
                        <td class="sort-city"><?php echo $item['lname'] ?></td>
                        <td class="sort-city"><?php echo $item['email'] ?></td>
                        <td class="sort-type"><?php echo explode(' ',$item['createdAt'])[0] ?></td>
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