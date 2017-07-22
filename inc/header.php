<?php
    $filepath = realpath(dirname(__FILE__));
    include_once $filepath."/../lib/Session.php";
    Session::init();

    if(isset($_GET['action']) && $_GET['action']== 'logout'){
        Session::destroy();
    }

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <link rel="stylesheet" href="inc/bootstrap.min.css">
</head>

<body>

<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="index.php" class="navbar-brand">Login Register php oop</a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php">Home</a></li>
                <?php
                    $userId = Session::get('id');
                    $loggedin = Session::get('login');
                    if($loggedin) :
                ?>
                <li><a href="profile.php?id=<?php echo $userId?>">Profile</a></li>
                <li><a href="?action=logout">Logout</a></li>
                <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>
