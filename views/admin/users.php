<?php 
require_once './../../classes/Enseignant.php';
require_once './../auth/user.php';
session_start();

if(!User::verifyAuth('admin')){
  header('Location: ./../auth/login.php');
}

$enseignant = new Enseignant(null, null, null, null, null);
$etudiant = new Etudiant(null, null, null, null, null);

$enseignants = $enseignant->getAll() ?? [] ;
$etudiants = $etudiant->getAll() ?? [] ;
$data = array_merge($enseignants, $etudiants);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
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

      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Category list
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
                        <th><button class="table-sort">Name</button></th>
                        <th><button class="table-sort">Email</button></th>
                        <th><button class="table-sort">Role</button></th>
                        <th><button class="table-sort">Status</button></th>
                        <th><button class="table-sort">Updated at</button></th>
                        <th><button class="table-sort">Actions</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      <?php foreach($data as $index => $item): ?>
                      <tr>
                        <td class="sort-name"><?php echo $index+1 ?></td>
                        <td class="sort-city"><?php echo $item['fname'].' '.$item['lname'] ?></td>
                        <td class="sort-city"><?php echo $item['email'] ?></td>
                        <td class="sort-city"><?php echo $item['role'] ?></td>
                        <td class="sort-city"><?php echo $item['suspended'] == 1 ? 'Suspended' : 'Activated' ?></td>
                        <td class="sort-score"><?php echo explode(' ', $item['updatedAt'])[0] ?></td>
                        <td class="sort-date">
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" style="display: inline;">
                              <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                              <?php if($item['suspended'] == 1): ?>
                                <button type="submit" name="activate" style="color:green; background:transparent; border:none;">Activte</button>
                              <?php else: ?>
                                <button type="submit" name="suspend" style="color:red; background:transparent; border:none;">Suspend</button>
                              <?php endif; ?>
                            </form>
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" style="display: inline;">
                              <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                              <button type="submit" name="delete" style="color:red; background:transparent; border:none;">delete</button>
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

      </div>
    </div>
    <!-- Libs JS -->
    <script src="./../../dist/libs/list.js/dist/list.min.js?1692870487" defer></script>
    <!-- Tabler Core -->
    <script src="./../../dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./../../dist/js/demo.min.js?1692870487" defer></script>
  </body>
</html>