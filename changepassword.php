<?php
include "lib/User.php";
$user = new User();
$userData = false;
if(isset($_GET['id'])){
    $userId = (int)$_GET['id'];
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatepass'])){
    $updatPassword = $user->updatePassword($userId, $_POST);
}
$userData = $user->getUserById($userId);

include "inc/header.php";
Session::checkSession();
if($userId != Session::get('id')) {
    echo '<script> window.location = "index.php";</script>';
}
?>
    <div class="main_content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if(isset($updatPassword)){
                        echo $updatPassword;
                    }
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title clearfix">User Profile <span class="pull-right"><a href="profile.php?id=<?php echo $userId ?>" class="btn btn-primary">Back</a></span></h3>
                        </div>
                        <div class="panel-body" style="padding: 50px 0">
                            <div class="col-md-6 col-md-offset-3">
                                <?php if($userData): ?>
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label for="oldpass">Old Password</label>
                                            <input name="old_password" type="password" class="form-control" id="oldpass" placeholder="Old Password" ">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input name="password" type="password" class="form-control" id="password" placeholder="New Password">
                                        </div>
                                        <button type="submit" class="btn btn-success" name="updatepass">Update</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "inc/footer.php" ?>