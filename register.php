<?php
  session_start();
  $_SESSION['username'] = NULL;
  $usrname = "";
  $password = "";
  $emailID = "";
  $errormsg = "";
  if (isset($_POST['registerbtn'])) {
    $db = mysqli_connect('localhost', 'newroot', '12345', 'expmgr') or die("connection to mysql failed");
    $usrname = mysqli_real_escape_string($db, $_POST['username']);
    $emailID = mysqli_real_escape_string($db, $_POST['emailid']);
    $pass = mysqli_real_escape_string($db, $_POST['password']);
    $pass2 = mysqli_real_escape_string($db, $_POST['password2']);
    if ($pass == $pass2) {
      $result = mysqli_query($db, "SELECT * FROM user WHERE email='$emailID' LIMIT 1");
      if (!mysqli_fetch_assoc($result)) {
        $pass = md5($pass);
        $query = "INSERT INTO user(username, email, pass) VALUES ('$usrname','$emailID','$pass') ";
        mysqli_query($db, $query) or die("insert not done");
        $_SESSION['username'] = $usrname;
        $_SESSION['emailID'] = $emailID;
        header('location: dashboard.php');
      } else {
        print("<span class='alert alert-danger'>user already exists</span>");
      }
    } else {
      $errormsg = 'passwords doesnt match';
      $_SESSION['Errors'] = $errormsg;
    }
  }

?>

<!DOCTYPE html>
<html>

<head>
  <title>page1</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="register.css" />
</head>

<body>
  <nav class="navbar navbar-dark bg-dark">
    <div class="navbar-brand">
      <a class="titleName" href="index.php"> Daily Expense Manager</a>
    </div>
  </nav>
  <div class="regSection">
    <form class="myForm text-center" action="register.php" method="POST">
      <header class="heading">Registration Form</header>
      <div class="form-group">
        <input type="text" class="myInput" id="name" placeholder="name" required name="username">
      </div>
      <div class="form-group">
        <input type="email" class="myInput" id="emailID" placeholder="emailID" required name="emailid">
      </div>
      <div class="form-group">
        <input type="password" class="myInput" id="emailID" placeholder="password" required name="password">
      </div>
      <div class="form-group">
        <input type="password" class="myInput" id="emailID" placeholder="re-enter password" required name="password2">
      </div>


      <input type="submit" class="SubmitBtn" value="Register" name="registerbtn">

      <a class="loginLink" href="index.php">Already User? Login</a>
    </form>
  </div>
  </body>

</html>