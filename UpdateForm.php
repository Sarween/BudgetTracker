<?php
require_once "pdo.php";
//Start a new session

session_start();

if (isset($_POST['type']) && isset($_POST['date']) && isset($_POST['time']) && isset($_POST['amount']) && isset($_POST['transactionID'])) {
  echo("Helo");

  $sql = "UPDATE TransactionTable SET type = :type, date = :date, time = :time, amount = :amount WHERE transactionID = :tid";
  $db = new DBController();
  $stmt = $db->getDB()->prepare($sql);
  $stmt->execute(array(
    ':type' => $_POST['type'],
    ':date' => $_POST['date'],
    ':time' => $_POST['time'],
    ':amount' => $_POST['amount'],
    ':tid' => $_POST['transactionID']
  ));
  $_SESSION['success'] = 'Record updated';
  header("Location: UpdateForm.php");
  return;
}

require_once "pdo.php";
$db = new DBController();
$stmt = $db->getDB()->prepare("SELECT transactionID, type, date, time, amount FROM TransactionTable WHERE transactionID = :tid");
$stmt->execute(array(':tid' => $_SESSION['transactionID']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
  $_SESSION['error'] = 'Bad value for user_id';
  header('Location: Transaction.php');
  return;
}
$type = htmlentities($row['type']);
$date = htmlentities($row['date']);
$time = htmlentities($row['time']);
$amount = htmlentities($row['amount']);
$transactionID = $row['transactionID'];


if ($type === "Accommodation")
  $op = 0;
elseif ($type === "Shopping")
  $op = 1;
elseif ($type === "Food")
  $op = 2;
elseif ($type === "Transportation")
  $op = 3;
elseif ($type === "Salary")
  $op = 4;
elseif ($type === "Incoming Transfer")
  $op = 5;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Update Transaction</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <script type="text/javascript">
	   function validateForm() {
		     if (document.addForm.type.value == null || document.addForm.type.value == "") {
			       alert("Please enter transaction type");
			       return false;
		     }
		     if (document.addForm.date.value == null || document.addForm.date.value == "") {
		       	alert("Please enter transaction date");
			     return false;
		     }
         if (document.addForm.time.value == null || document.addForm.time.value == "") {
		       	alert("Please enter transaction time");
			     return false;
		     }
         if (document.addForm.amount.value == null || document.addForm.amount.value == "") {
		       	alert("Please enter transaction amount");
			     return false;
		     }
         if (isNaN(document.addForm.amount.value)) {
           alert("Please enter numeric value");
          return false;
          }
         if (Number(document.addForm.amount.value) === 0) {
           alert("Amount cannot be $0");
          return false;
         }
	    }
    </script>

    <style>
      body {
          background-image: url("https://static.vecteezy.com/system/resources/thumbnails/004/515/057/small/watercolor-texture-background-free-vector.jpg");
          background-position: center center;
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: cover;
          background-color: #464646;
          color:white;
      }
    </style>
</head>

<body>
    <div class="container">
      <div class="position-absolute mt-5 mb-5 top-0 start-50 translate-middle-x text-dark p-5">

        <h1 class="text-center">Update Selected Transaction Record</h1><br/>

        <?php
          if (isset($_SESSION['failure'])) { //If there is error message
            print '<p class="text-center" style="color:red">';
            print $_SESSION['failure'];
            print "</p>\n";
            unset($_SESSION['failure']);
          }
          if (isset($_SESSION['success'])) { //If there is success message
          	print '<p class="text-center" style="color:green">';
          	print $_SESSION['success'];
          	print "</p>\n";
            unset($_SESSION['success']);
          }
        ?>

        <!-- Starting of form -->
        <form method="POST" name="addForm" onSubmit="return validateForm()">
          <div class="mb-3 row">
            <label for="type" class="col">Choose a transaction:</label>
            <div class="col-sm-8">
              <select id="type" name="type">
                <option <?php if($op == '0'){echo("selected");}?> value="Accommodation">Accommodation</option>
                <option <?php if($op == '1'){echo("selected");}?> value="Shopping">Shopping</option>
                <option <?php if($op == '2'){echo("selected");}?> value="Food">Food</option>
                <option <?php if($op == '3'){echo("selected");}?> value="Transportation">Transportation</option>
                <option <?php if($op == '4'){echo("selected");}?> value="Salary">Salary</option>
                <option <?php if($op == '5'){echo("selected");}?> value="Incoming Transfer">Incoming Transfer</option>
              </select>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="date" class="col-sm-4 col-form-label">Date</label>
            <div class="col-sm-8">
              <input type="date" name="date" value="<?= $date ?>" class="form-control">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="time" class="col-sm-4 col-form-label">Time</label>
            <div class="col-sm-8">
              <input type="time" name="time" value="<?= $time ?>"class="form-control">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="amount" class="col-sm-4 col-form-label">Amount</label>
            <div class="col-sm-8">
              <input type="text" name="amount" value="<?= $amount ?>" class="form-control">
            </div>
          </div>
          <div class="mb-2 mt-2 text-center">
            <input type="hidden" name="transactionID" value="<?= $transactionID ?>">
            <input class="btn btn-success" type="submit" value="Update Transaction">
          </div>
        </form>
        <!-- End of form -->
      </div>
    </div>
    <a href="Transaction.php"><button type="button" class="btn btn-primary btn-lg" style="background-color: #DE4C0D; padding: 10px 20px; cursor: pointer; display: flex; justify-content: left; align-items: center; border-radius: 5px; position: absolute; top: 5%; right: 2%">Back to Transaction Page</button></a>
  </body>
  </body>
</html>
