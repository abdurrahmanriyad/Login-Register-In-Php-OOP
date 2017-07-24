<?php
    include_once "lib/User.php";
    include_once "lib/UserAuthentication.php";
    $userObject = new User();
    $userAuthentication = new UserAuthentication();

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
        $userRegistration = $userAuthentication->userRegistration($_POST);
    }

    include "inc/header.php";
    $userAuthentication->checkLogin();
?>
    <div class="main_content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">User Registration</h3>
                        </div>
                        <div class="panel-body" style="padding: 50px 0">
                            <div class="col-md-6 col-md-offset-3">
                                <?php
                                    if(isset($userRegistration)){
                                        echo $userRegistration;
                                    }
                                ?>
                                <form method="post" action="">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Name" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Username</label>
                                        <input type="text" class="form-control" id="name" placeholder="Username" name="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                                    </div>
                                    <button type="submit" name="register" class="btn btn-success">Register</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "inc/footer.php" ?>