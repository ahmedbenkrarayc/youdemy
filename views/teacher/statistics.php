<?php
session_start();
require_once './../../classes/Enseignant.php';
require_once './../auth/user.php';

if(!User::verifyAuth('enseignant')){
    header('Location: ./../auth/login.php');
}

$enseignant = new Enseignant($_SESSION['user_id'], null, null, null, null);
$top10 = $enseignant->coursCountInscriptions() ?? [];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Statistics | Youdemy</title>
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
                        Statistics
                    </h2>
                </div>
                
                <div class="row row-cards" style="margin-top: 20px;">
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="avatar rounded">ST</span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                    <?php echo $enseignant->studentCount() ?? 0 ?>
                                    </div>
                                    <div class="text-secondary">
                                    Students
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="avatar rounded">CR</span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                    <?php echo $enseignant->coursCount() ?? 0 ?>
                                    </div>
                                    <div class="text-secondary">
                                    Courses
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="avatar rounded">IN</span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                    <?php echo $enseignant->todayInscriptionCount() ?? 0 ?>
                                    </div>
                                    <div class="text-secondary">
                                    Today's inscriptions
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-xl" style="margin-top: 60px;">
                    <h3 class="page-title" style="margin-bottom: 30px;">Top 10 courses</h3>
                    <div class="card">
                    <div class="card-body">
                        <div id="table-default" class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th><button class="table-sort">#</button></th>
                                <th><button class="table-sort">Title</button></th>
                                <th><button class="table-sort">Inscriptions</button></th>
                            </tr>
                            </thead>
                            <tbody class="table-tbody">
                            <?php foreach($top10 as $index => $item ): ?>
                                <tr>
                                    <td class="sort-name"><?php echo $index+1 ?></td>
                                    <td class="sort-city"><?php echo $item['title'] ?></td>
                                    <td class="sort-city"><?php echo $item['ninscrit'] ?></td>
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