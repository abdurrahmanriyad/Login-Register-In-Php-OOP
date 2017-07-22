<?php
    include "lib/User.php";
    $user = new User();
    include "inc/header.php";
    Session::checkSession();
?>
    <div class="main_content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $loginMsg = Session::get('login_msg');
                    if($loginMsg){
                        echo $loginMsg;
                    }
                    Session::set('login_msg', NULL);
                    ?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">User List
                                <span class="pull-right"><strong>Hello!</strong> <?php $name = Session::get('name'); if(isset($name)) { echo $name;} ?></span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="20%">Serial</th>
                                    <th width="20%">Name</th>
                                    <th width="20%">Username</th>
                                    <th width="20%">Email</th>
                                    <th width="20%">Action</th>
                                </tr>
                                <?php
                                $users = $user->getAllUser();
                                if($users):
                                    $id = 0;
                                    foreach($users as $user):
                                ?>
                                        <tr>
                                            <td><?php echo $id++; ?></td>
                                            <td><?php echo $user->name ?></td>
                                            <td><?php echo $user->username ?></td>
                                            <td><?php echo $user->email ?></td>
                                            <td>
                                                <a class="btn btn-primary" href="profile.php?id=<?php echo $user->id ?>">View</a>
                                            </td>
                                        </tr>

                                <?php
                                    endforeach;
                                    else:
                                ?>
                                    <tr>
                                        <td colspan="5">No data found!!</td>
                                    </tr>
                                <?php
                                    endif;
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "inc/footer.php" ?>