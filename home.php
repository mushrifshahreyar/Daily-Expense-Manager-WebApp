<?php

  session_start();
  $_SESSION['username']=NULL;
  $emailID = "";
  $pass = "";

  $db = mysqli_connect('localhost', 'newroot', '12345', 'expmgr') or die('could not connect');

  if (isset($_POST['login'])) {
    $emailID = mysqli_real_escape_string($db, $_POST['emailid']);
    $pass = mysqli_real_escape_string($db, $_POST['password']);
    $pass = md5($pass);
    $query = "SELECT * FROM user WHERE email = '$emailID' AND pass = '$pass' ";
    $results = mysqli_query($db, $query) or die("unable to check at the moment");
    $user = mysqli_fetch_assoc($results);
    if (mysqli_num_rows($results)) {
      $_SESSION['username'] = $user['username'];
      $_SESSION['emailID'] = $user['email'];
      header("location: dashboard.php");
    } else {
      print("credentials dont match");
    }
  }
  
?>



<!DOCTYPE html>
<html>

<head>
  <title>page1</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="home.css" />
</head>

<body>

  <div class="row">
    <div class="col-md-8">
      <div class="titleSection">
        <div class="box">
          <header>Welcome to Daily Expense Tracker</header>
          <p>
            This project aims to create a web application that manages the daily expenses of its
            users. Each user will have to register and login to use the app. Once logged in, you
            will be able to see the spending logs ordered by the entry time. Clicking on an entry
            would provide the details associated with that expense. A separate section will allow
            you to log the expenses where you can also specify the payment method used.
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="loginSection">
        <form class="myForm text-center" action="#" method="POST">
          <header>Login</header>
          <div class="form-group">
            <!-- <i class="fas fa-user"></i> -->
            <!-- <label class = "myLabel" for="username">Username</label> -->
            <input type="email" class="myInput" id="emailID" placeholder="email ID" name="emailid" required>
          </div>

          <div class="form-group">
            <!-- <i class="fas fa-lock"></i> -->
            <!-- <label class = "myLabel" for="password">Password</label> -->
            <input type="password" class="myInput" id="password" placeholder="password" name="password" required>
          </div>
          <input type="submit" class="SubmitBtn" value="login" name="login">
          <a class = "registerLink" href="register.php">New User? Register</a>
        
        </form>
      </div>
    </div>
  </div>

</body>

</html>