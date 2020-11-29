<?php 
    session_start();

    if($_SESSION['username'] == NULL) {
        header('location: home.php');
    }
    $message = NULL;
    $db = mysqli_connect('localhost', 'newroot', '12345', 'expmgr') or die("connection to mysql failed");
    $emailID = mysqli_real_escape_string($db, $_SESSION['emailID']);
    $result = mysqli_query($db, "SELECT * FROM user WHERE email='$emailID' LIMIT 1");
    $user = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result)) {
      
    } else {
      print("credentials dont match");
    }
    if(isset($_POST['updateBtn'])) {
        
        $oldpass = $_POST['oldPass'];
        $oldpass = md5($oldpass);
        $newPass = $_POST['newPass'];
        if(($user['pass'] == $oldpass)) {
            $usrname = $_POST['name'];
            $newPass = $_POST['newPass'];
            $re_newPass = $_POST['re-newPass'];
            if(strlen($newPass) != 0 || strlen($re_newPass) != 0) {
                $newPass = md5($newPass);
                $re_newPass = md5($re_newPass);
                if($newPass == $re_newPass) {
                    $email = $user['email'];
                    $query = "UPDATE user SET username='$usrname' , pass='$newPass' WHERE email='$email'";
                    mysqli_query($db,$query) or die("Insert not done"); 
                    $_SESSION['username'] = $usrname;
                    $message="Updated Successfully";
                }
                else {
                    $message = "Password not matching";
                }
            }
            else {
                $email = $user['email'];
                $query = "UPDATE user SET username='$usrname' WHERE email='$email'";
                mysqli_query($db,$query) or die("Insert not done"); 
                $_SESSION['username'] = $usrname;
                $message="Username changed Successfully";
            }
            
        }
        else {
            $message = "Old password is wrong\nTry Again";
        }
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="settings.css">
    </head>

    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a href="dashboard.php" class="navbar-brand">Daily Expense Manager</a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Hi <?= $_SESSION['username'];?></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="dashboard.php" class="dropdown-item">Home</a>
                            <a href="#" class="dropdown-item">View past transactions</a>
                            <div class="dropdown-divider"></div>
                            <a href="home.php" class="dropdown-item">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

    
        
        <div class="container container-form">
            <div class="card-body">
            <h2 class="form-title">Edit Information</h2>
            <form action="#" method="post">

                <div class="form-group row">
                    <label class="col-lg-5 col-form-label">Name</label>
                    <div class="col-lg-7">
                      <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?=  $_SESSION['username'];?>">
                </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-5 col-form-label">Email</label>
                    <div class="col-lg-7">
                      <input type="email" class="form-control" id="email" name="emailID" placeholder="Email" value="<?= $user['email'];?>" disabled>
                </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-5 col-form-label">Old Password</label>
                    <div class="col-lg-7">
                      <input type="password" class="form-control" name="oldPass" id="old_pass" placeholder="Old Password">
                </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-5 col-form-label">New Password</label>
                    <div class="col-lg-7">
                      <input type="password" class="form-control" id="new_pass" name="newPass" placeholder="New Password">
                </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-5 col-form-label">Re-type Password</label>
                    <div class="col-lg-7">
                      <input type="password" class="form-control" id="re_pass" name="re-newPass" placeholder="Re-type Password">
                </div>
                </div>
            <div class="Change-btn">
                <input type="submit" value="Submit" class="btn btn-primary btn-md" id="Change" name="updateBtn"></input>
            </div>
            <div class="form-group row">
                    <label class="message col-lg-5 col-form-label"><?= $message?></label>
            </div>
            </form>
        </div>
        </div>

        
    </body>


</html>
