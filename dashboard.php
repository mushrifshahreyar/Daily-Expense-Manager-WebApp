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

  if (isset($_POST['card_submit'])) {
    $cardName = $_POST['cardName'];
    $cardexists = mysqli_query($db, "SELECT * FROM card WHERE card_name='$cardName'") or die("cardexists" . mysqli_error($db));
    if ($row = mysqli_fetch_assoc($cardexists)) {
    } else {
      mysqli_query($db, "INSERT INTO card(card_name, uid) VALUES ('$cardName', $uid)");
    }
    $_POST['card_submit'] = NULL;
  }

  if (isset($_POST['submit'])) {
    $date = date($_POST['date']);
    $amount = $_POST['amount'];
    $title = $_POST['title'];
    $type = $_POST['type']; //credit or debit
    $paymentType = $_POST['paymentType']; //upi or net banking or card

    if (isset($_POST['card'])) {
      $cardID = (int)$_POST['card'];
      mysqli_query($db, "INSERT INTO expense(uid, amount, title, payment_type, type, date, card_id) VALUES ($uid, $amount, '$title', '$paymentType', '$type', DATE '$date', $cardID)") or die("unable to insert into expense-card: " . mysqli_error($db));
    } elseif (isset($_POST['bank'])) {
      $bank = $_POST['bank'];
      mysqli_query($db, "INSERT INTO expense(uid, amount, title, payment_type, type, date, bank) VALUES ($uid, $amount, '$title', '$paymentType', '$type', DATE '$date', '$bank')") or die("unable to insert into expense-ib: " . mysqli_error($db));
    } else {
      mysqli_query($db, "INSERT INTO expense(uid, amount, title, payment_type, type, date) VALUES ($uid, $amount, '$title', '$paymentType', '$type', DATE '$date')") or die('unable to insert cash info');
    }
    $_POST['submit'] = NULL;
  }


?>

<!DOCTYPE html>
<html>

<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="dashboard.css" />
</head>

<script>
  payment = 0

  function removePayment() {
    if (payment >= 1) {
      document.getElementById('paymentInput').remove();
      payment = 0
    }
  }

  function addCard() {
    if (payment >= 1) {
      removePayment()
    }
    payment = 1
    var obj = document.getElementById("paymentDetail");
    const div = document.createElement('div')
    div.innerHTML = `<div id="paymentInput">
                      <label for="exampleFormControlSelect1">Card</label>
                        <select class="form-control" id="modeform" name="card">
                        <?php
                        $cards = mysqli_query($db, "SELECT card_id, card_name FROM card WHERE uid=$uid");
                        while ($rows = mysqli_fetch_assoc($cards)) {
                        ?>
                          <option value="<?= $rows['card_id'] ?>"><?= print($rows['card_name']); ?></option>
                         <?php } ?>
                        </select> 
                    </div>`;

    obj.appendChild(div);

  }

  function addBanking() {
    if (payment >= 1) {
      removePayment()
    }
    payment = 1
    var obj = document.getElementById("paymentDetail");
    const div = document.createElement('div')
    div.innerHTML = `<div id="paymentInput">
                      <div class="form-group">
                        <label for="exampleFormControlInput1">Bank Detail</label>
                        <input type="text" class="form-control" id="bankDetail" placeholder="Bank Detail" name="bank" required>
                      </div>
                    </div>`;

    obj.appendChild(div);

  }
</script>

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
            <a href="view_all.php" class="dropdown-item">View past transactions</a>
            <a href="settings.php" class="dropdown-item">Edit Information</a>
            <a type="button" class="dropdown-item" data-toggle="modal" data-target="#myModal">Add card</a>
            <div class="dropdown-divider"></div>
            <a href="logout.php" class="dropdown-item">Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!-- Dialog box for add card -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">


      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <!-- Form for entering card details -->
          <form action="dashboard.php" method="POST">
            <div class="form-group">
              <label for="card name">
                <h5>Card name</h5>
              </label>
              <input type="text" class="form-control" id="cardname" placeholder="card name" name="cardName">
            </div>
            <button type="submit" class="btn btn-primary" name="card_submit">Submit</button>
          </form>
        </div>
        <!-- Form ending -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
  <!-- Dialog box for add card -->

  <!-- First row for showing summary -->
  <div class="firstrow">
    <div class="row">
      <div class="col-6 row1col1">
        <div class="currentmonth">

          <?php
          $currMonth = date('F');
          $res = mysqli_query($db, "SELECT SUM(amount) FROM expense WHERE MONTHNAME(date)='$currMonth' AND type='debit' AND uid=$uid");
          $debit = (float)mysqli_fetch_assoc($res)['SUM(amount)'];
          $res = mysqli_query($db, "SELECT SUM(amount) FROM expense WHERE MONTHNAME(date)='$currMonth' AND type='credit' AND uid=$uid");
          $credit = (float)mysqli_fetch_assoc($res)['SUM(amount)'];
          $limit = 15000;
          $savings = $credit - $debit;
          ?>

          <h2 id="currentmonthname"><?php print($currMonth); ?></h2>
          <div class="transactiondetails">
            <p id="totalcredit">Overall Credit : <b><?php print($credit); ?></b></p>
            <p id="totaldebit">Total money spent : <b><?php print($debit) ?></b></p>
            <!-- <p id="totallimit">Total Limit : <b>15000</b></p> -->
            <p id="moneyspent">Balance : <b><?php print($savings); ?></b></p>
          </div>
        </div>
      </div>
      <div class="col-6 row1col2">
        <div class="prevmonth">

          <?php
          $lastMonth = date('F', strtotime('last month'));
          $res = mysqli_query($db, "SELECT SUM(amount) FROM expense WHERE MONTHNAME(date)='$lastMonth' AND type='debit' AND uid=$uid");
          $debit = (float)mysqli_fetch_assoc($res)['SUM(amount)'];
          $res = mysqli_query($db, "SELECT SUM(amount) FROM expense WHERE MONTHNAME(date)='$lastMonth' AND type='credit' AND uid=$uid");
          $credit = (float)mysqli_fetch_assoc($res)['SUM(amount)'];
          $limit = 15000;
          $balance = ($credit - $debit)<0 ? 0 : $credit-$debit;
          ?>

          <h2 id="prevmonthname"><?php print($lastMonth); ?></h2>
          <div class="transactiondetails">
            <p id="totalcredit">Overall Credit : <b><?php print($credit); ?></b></p>
            <p id="totaldebit">Total money spent : <b><?php print($debit) ?></b></p>
            <p id="totallimit">You saved : <b><?php print($balance) ?></b></p>
            <!-- <p id="moneyspent">You saved : <b><?php print($savings); ?></b></p> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- First row for showing summary -->

  <!-- Second row for adding details and showing latest transactions -->
  <div class="secondrow">
    <div class="row">
      <div class="col-6 row2col1">
        <h2 id="adddetails">Add details</h2>
        <div class="formentry">

          <!-- FORM FOR ENTERING TRANSACTION DETAILS -->
          <form action="dashboard.php" method="POST">
            <div class="form-group">
              <label class="control-label" for="date">Date</label>
              <input class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="date" max="<?php echo date("Y-m-d"); ?>" />
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput1">Title</label>
              <input type="text" class="form-control" id="titleform" placeholder="Title" name="title" required>
            </div>
            <div class="form-group">
              <label for="paymentType">Payment Type</label>
            </div>
            <div class="form-group">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="paymentType" id="cashPayment" value="cashPayment" checked onclick="removePayment()">
                <label class="form-check-label" for="inlineRadio2">Cash</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="paymentType" id="cardPayment" value="cardPayment" onclick="addCard()">
                <label class="form-check-label" for="inlineRadio1">Card</label>
              </div>

              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="paymentType" id="internetBanking" value="internetBanking" onclick="addBanking()">
                <label class="form-check-label" for="inlineRadio2">Internet Banking</label>
              </div>
            </div>
            <div class="form-group" id="paymentDetail"></div>
            <div class="form-group">
              <label for="exampleFormControlInput1">Amount</label>
              <input type="number" class="form-control" id="amountform" placeholder="Amount" name="amount">
            </div>

            <div class="form-group">
              <label for="type">Type</label>
            </div>
            <div class="form-group">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="debitform" value="debit" checked>
                <label class="form-check-label" for="inlineRadio2">Debit</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="creditform" value="credit">
                <label class="form-check-label" for="inlineRadio1">Credit</label>
              </div>

            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
          </form>

        </div>
      </div>
      <div class="col-6 row2col2">
        <h2 id="transactiondetailstable">Transaction details <a href="view_all.php"><button class="btn btn-primary" type="submit" style="margin-left: 25px;">View all</button> </a></h2>

        <div class="transactiontable">
          <div class="table-responsive">
            <table class="table table-hover table-dark">
              <thead class="thead-dark">
                <tr>
                  <th class="header" scope="col">Sl No.</th>
                  <th class="header" scope="col">Date</th>
                  <th class="header" scope="col">Title</th>
                  <th class="header" scope="col">Amount</th>
                  <th class="header" scope="col">Mode</th>
                  <th class="header" scope="col">Type</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $results = mysqli_query($db, "SELECT title, date, amount, payment_type, type FROM expense WHERE uid=$uid ORDER BY date DESC LIMIT 10 ");
                $i = 1;
                while ($rows = mysqli_fetch_assoc($results)) {
                ?>
                  <tr>
                    <th scope="row"><?php print($i); ?></th>
                    <td><?php print($rows['date']); ?></td>
                    <td><?php print($rows['title']); ?></td>
                    <td><?php print($rows['amount']); ?></td>
                    <td><?php print($rows['payment_type']); ?></td>
                    <td><?php print($rows['type']); ?></td>
                  </tr>
                <?php $i += 1;
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>