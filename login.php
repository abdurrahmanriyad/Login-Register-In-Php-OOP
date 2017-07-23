<?php
    include_once "lib/User.php";
    include_once "lib/UserAuthentication.php";
    $user = new User();
    $userAuthentication = new UserAuthentication();

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
        $userLogin = $userAuthentication->userLogin($_POST);
    }

    include "inc/header.php";
    Session::checkLogin();
?>
    <div class="main_content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">User Login</h3>
                        </div>
                        <div class="panel-body" style="padding: 50px 0">
                            <div class="col-md-6 col-md-offset-3">
                                <?php
                                if(isset($userLogin)){
                                    echo $userLogin;
                                }
                                ?>
                                <form method="POST" action="">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" id="emial" placeholder="Email" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                                    </div>
                                    <button type="submit" class="btn btn-success" name="login">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "inc/footer.php" ?>