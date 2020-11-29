<?php 
    session_start();

    if($_SESSION['username'] == NULL) {
        header('location: home.php');
    }

    $emailID = $_SESSION['emailID'];
    
    $db = mysqli_connect('localhost', 'newroot', '12345', 'expmgr') or die('unable to estabilish connection with database');

    $result = mysqli_query($db, "SELECT uid FROM user WHERE email='$emailID'") or die('unable to retrieve uid');
    $row = mysqli_fetch_assoc($result);
    $uid = $row['uid'];

    
    

?>


<!DOCTYPE html>


<html>
    <head>
        <title>View all</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="view_all.css" />
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
                  <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Hi <?php print($_SESSION['username']); ?></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a href="home.php" class="dropdown-item">Home</a>
                    <a href="settings.php" class="dropdown-item">Edit Information</a>
                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-item">Logout</a>
                  </div>
                </li>
              </ul>
            </div>
        </nav>
        
  
        <h3 class="heading">Past Transactions</h3>

  

        <div class="container">
        <table class="table table-hover table-section">
            <thead class="thead-dark">
              <tr>
                <th scope="col">S No</th>
                <th scope="col">Date</th>
                <th scope="col">Title</th>
                <th scope="col">Amount</th>
                <th scope="col">Payment Type</th>
                <th scope="col">Bank Name</th>
                <th scope="col">Card Name</th>
                <th scope="col">Type</th>
              </tr>
            </thead>
            <tbody>
            <?php
                $results = mysqli_query($db, "SELECT title, date, amount, payment_type, bank, card_id, type FROM expense WHERE uid=$uid ORDER BY date DESC");
                $i = 1;
                while ($rows = mysqli_fetch_assoc($results)) {
                ?>
                  <tr>
                    <th scope="row"><?php print($i); ?></th>
                    <td><?php print($rows['date']); ?></td>
                    <td><?php print($rows['title']); ?></td>
                    <td><?php print($rows['amount']); ?></td>
                    <td><?php print($rows['payment_type']); ?></td>
                    <td><?php if($rows['bank'] == NULL) {print("-");}
                                else {
                                    print($rows['bank']);
                                }?>
                    <td><?php if($rows['card_id'] == NULL) {print("-");}
                                else {
                                    $cardID = (int)$rows['card_id'];
                                    $cardTable = mysqli_query($db, "SELECT card_name FROM card WHERE card_id = $cardID and uid=$uid");
                                    $cardName = mysqli_fetch_assoc($cardTable);
                                    print($cardName['card_name']);
                                }?>
                    <td><?php print($rows['type']); ?></td>
                  </tr>
                <?php $i += 1;
                } ?>
            </tbody>
        </table>
        </div>
    </body>
</html>
