<header class="navbar navbar-expand-md d-print-none" >
<div class="container-xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
    <a href="./">
        <img src="./../../static/logo.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
    </a>
    </h1>
    <div class="navbar-nav flex-row order-md-last">
    <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
        <div class="d-none d-xl-block ps-2">
            <div><?php echo $GLOBALS['authUser'] ? $GLOBALS['authUser']['fname'].' '.$GLOBALS['authUser']['lname'] : 'Guest' ?></div>
            <div class="mt-1 small text-secondary"><?php echo $GLOBALS['authUser'] ? $GLOBALS['authUser']['role'] : 'Guest' ?></div>
        </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <?php if($GLOBALS['authUser']): ?>
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/auth/login.php' ?>" class="dropdown-item">Settings</a>
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/auth/logout.php' ?>" class="dropdown-item">Logout</a>
            <?php else: ?>
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/auth/login.php' ?>" class="dropdown-item">Login</a>
            <?php endif; ?>
        </div>
    </div>
    </div>
</div>
</header>
<header class="navbar-expand-md">
<div class="collapse navbar-collapse" id="navbar-menu">
    <div class="navbar">
        <div class="container-xl">
            <?php if($GLOBALS['authUser'] && $GLOBALS['authUser']['role'] == 'admin'): ?>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'] ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l11 0"></path><path d="M9 12l11 0"></path><path d="M9 18l11 0"></path><path d="M5 6l0 .01"></path><path d="M5 12l0 .01"></path><path d="M5 18l0 .01"></path></svg>
                    </span>
                    
                    <span class="nav-link-title">
                        Home
                    </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/admin/statistics.php' ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l11 0"></path><path d="M9 12l11 0"></path><path d="M9 18l11 0"></path><path d="M5 6l0 .01"></path><path d="M5 12l0 .01"></path><path d="M5 18l0 .01"></path></svg>
                    </span>
                    
                    <span class="nav-link-title">
                        Statistics
                    </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/admin/categories.php' ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l11 0"></path><path d="M9 12l11 0"></path><path d="M9 18l11 0"></path><path d="M5 6l0 .01"></path><path d="M5 12l0 .01"></path><path d="M5 18l0 .01"></path></svg>
                    </span>
                    
                    <span class="nav-link-title">
                        Categories
                    </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/admin/addcategory.php' ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 8v-2a2 2 0 0 1 2 -2h2"></path><path d="M4 16v2a2 2 0 0 0 2 2h2"></path><path d="M16 4h2a2 2 0 0 1 2 2v2"></path><path d="M16 20h2a2 2 0 0 0 2 -2v-2"></path><path d="M9 12l6 0"></path><path d="M12 9l0 6"></path></svg>
                    </span>
                    <span class="nav-link-title">
                        Category
                    </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/admin/tags.php' ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l11 0"></path><path d="M9 12l11 0"></path><path d="M9 18l11 0"></path><path d="M5 6l0 .01"></path><path d="M5 12l0 .01"></path><path d="M5 18l0 .01"></path></svg>
                    </span>
                    
                    <span class="nav-link-title">
                        Tags
                    </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/admin/addtag.php' ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 8v-2a2 2 0 0 1 2 -2h2"></path><path d="M4 16v2a2 2 0 0 0 2 2h2"></path><path d="M16 4h2a2 2 0 0 1 2 2v2"></path><path d="M16 20h2a2 2 0 0 0 2 -2v-2"></path><path d="M9 12l6 0"></path><path d="M12 9l0 6"></path></svg>
                    </span>
                    <span class="nav-link-title">
                        Tag
                    </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/admin/requests.php' ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l11 0"></path><path d="M9 12l11 0"></path><path d="M9 18l11 0"></path><path d="M5 6l0 .01"></path><path d="M5 12l0 .01"></path><path d="M5 18l0 .01"></path></svg>
                    </span>
                    
                    <span class="nav-link-title">
                        Requests
                    </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/admin/users.php' ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l11 0"></path><path d="M9 12l11 0"></path><path d="M9 18l11 0"></path><path d="M5 6l0 .01"></path><path d="M5 12l0 .01"></path><path d="M5 18l0 .01"></path></svg>
                    </span>
                    
                    <span class="nav-link-title">
                        Users
                    </span>
                    </a>
                </li>
            </ul>
            <?php elseif($GLOBALS['authUser'] && $GLOBALS['authUser']['role'] == 'enseignant'): ?>
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'] ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l11 0"></path><path d="M9 12l11 0"></path><path d="M9 18l11 0"></path><path d="M5 6l0 .01"></path><path d="M5 12l0 .01"></path><path d="M5 18l0 .01"></path></svg>
                    </span>
                    
                    <span class="nav-link-title">
                        Home
                    </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/teacher/statistics.php' ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l11 0"></path><path d="M9 12l11 0"></path><path d="M9 18l11 0"></path><path d="M5 6l0 .01"></path><path d="M5 12l0 .01"></path><path d="M5 18l0 .01"></path></svg>
                    </span>
                    
                    <span class="nav-link-title">
                        Statistics
                    </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/teacher/courses.php' ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l11 0"></path><path d="M9 12l11 0"></path><path d="M9 18l11 0"></path><path d="M5 6l0 .01"></path><path d="M5 12l0 .01"></path><path d="M5 18l0 .01"></path></svg>
                    </span>
                    
                    <span class="nav-link-title">
                        Courses
                    </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/teacher/addcourse.php' ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 8v-2a2 2 0 0 1 2 -2h2"></path><path d="M4 16v2a2 2 0 0 0 2 2h2"></path><path d="M16 4h2a2 2 0 0 1 2 2v2"></path><path d="M16 20h2a2 2 0 0 0 2 -2v-2"></path><path d="M9 12l6 0"></path><path d="M12 9l0 6"></path></svg>
                    </span>
                    <span class="nav-link-title">
                        Course
                    </span>
                    </a>
                </li>
            </ul> 
            <?php elseif($GLOBALS['authUser'] && $GLOBALS['authUser']['role'] == 'etudiant'): ?>
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'] ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l11 0"></path><path d="M9 12l11 0"></path><path d="M9 18l11 0"></path><path d="M5 6l0 .01"></path><path d="M5 12l0 .01"></path><path d="M5 18l0 .01"></path></svg>
                    </span>
                    
                    <span class="nav-link-title">
                        Home
                    </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/etudiant/favorite.php' ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 8v-2a2 2 0 0 1 2 -2h2"></path><path d="M4 16v2a2 2 0 0 0 2 2h2"></path><path d="M16 4h2a2 2 0 0 1 2 2v2"></path><path d="M16 20h2a2 2 0 0 0 2 -2v-2"></path><path d="M9 12l6 0"></path><path d="M12 9l0 6"></path></svg>
                    </span>
                    <span class="nav-link-title">
                        Favorite
                    </span>
                    </a>
                </li>
            </ul> 
            <?php else: ?>
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'] ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l11 0"></path><path d="M9 12l11 0"></path><path d="M9 18l11 0"></path><path d="M5 6l0 .01"></path><path d="M5 12l0 .01"></path><path d="M5 18l0 .01"></path></svg>
                    </span>
                    
                    <span class="nav-link-title">
                        Home
                    </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/auth/login.php' ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 8v-2a2 2 0 0 1 2 -2h2"></path><path d="M4 16v2a2 2 0 0 0 2 2h2"></path><path d="M16 4h2a2 2 0 0 1 2 2v2"></path><path d="M16 20h2a2 2 0 0 0 2 -2v-2"></path><path d="M9 12l6 0"></path><path d="M12 9l0 6"></path></svg>
                    </span>
                    <span class="nav-link-title">
                        Login
                    </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/views/auth/signup.php' ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 8v-2a2 2 0 0 1 2 -2h2"></path><path d="M4 16v2a2 2 0 0 0 2 2h2"></path><path d="M16 4h2a2 2 0 0 1 2 2v2"></path><path d="M16 20h2a2 2 0 0 0 2 -2v-2"></path><path d="M9 12l6 0"></path><path d="M12 9l0 6"></path></svg>
                    </span>
                    <span class="nav-link-title">
                        Register
                    </span>
                    </a>
                </li>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
</header>