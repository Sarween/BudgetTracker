<?php
require_once "pdo.php";
//Start a new session
session_start();

if (isset($_POST['add'])) {
  header("Location: TransactionForm.php");
  return;
}

//Check if user want to delete record
if (isset($_POST['delete']) && isset($_POST['transactionID']) ) {
  $db = new DBController();
  $stmt = $db->getDB()->prepare("DELETE FROM TransactionTable WHERE transactionID = :tid");
  $stmt->bindValue( ":tid", $_POST['transactionID'], PDO::PARAM_INT );
  $stmt->execute(array(
    ':tid' => $_POST['transactionID'])
  );
  $stmt->execute();
  //Print success message
  $_SESSION['success'] = "Record deleted successfully";
  header("Location: Transaction.php");
  return;
}

if (isset($_POST['update'])) {
  $_SESSION['transactionID'] = $_POST['transactionID'];
  header("Location: UpdateForm.php");
  return;
}

//SQL statement to select all records from IncomingTable
require_once "pdo.php";
$db = new DBController();
$stmt = $db->getDB()->prepare("SELECT transactionID, userID, type, date, time, amount FROM TransactionTable WHERE userID = :uid");
$stmt->execute(array(
  ':uid' => $_SESSION['userID'])
);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Transaction Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <script>
    function ConfirmDelete()
    {
      return confirm("Are you sure you want to delete?");
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

        <h1 class="text-center">Transaction History</h1><br/>

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

        <!-- Starting of table -->
        <?php
          echo('<form method="POST"><input type="hidden"');
          echo('name="userID" value="'.$_SESSION['userID'].'">'."\n");
          echo('<input class="btn btn-success" type="submit" value="Add Transaction" name="add" style="position: absolute; right: 43%">');
          echo("\n</form>\n");
          echo("\n<br/>");
          echo("\n<br/><br/>".'<table class="table table-striped">')."\n";
          echo("<thead>");
          echo('<tr><th scope="col">Transaction ID');
          echo('</th><th scope="col">Type');
          echo('</th><th scope="col">Date');
          echo('</th><th scope="col">Time');
          echo('</th><th scope="col">Amount');
          echo('</th><th scope="col">Update');
          echo('</th><th scope="col">Delete');
          echo("</th></tr>");
          echo("</thead>");
          echo("<tbody>");
          $i=1  ;
          foreach ($rows as $row) {
            echo('<tr><th scope="row">');
            echo($i);
            echo("</th><td>");
            echo($row['type']);
            echo("</td><td>");
            echo($row['date']);
            echo("</td><td>");
            echo($row['time']);
            echo("</td><td>");
            echo($row['amount']);
            echo("</td><td>");
            $i++;
            //A new form to delete
            echo('<form method="POST"><input type="hidden"');
            echo('name="transactionID" value="'.$row['transactionID'].'">'."\n");
            echo('<input class="btn btn-info" type="submit" value="Update" name="update"> ');
            echo("\n</form>\n");
            echo("</td><td>");
            echo('<form method="POST"><input type="hidden"');
            echo('name="transactionID" value="'.$row['transactionID'].'">'."\n");
            echo('<input class="btn btn-danger" type="submit" value="Delete" name="delete" onclick="return ConfirmDelete()">');
            echo("\n</form>\n");
            echo("</td></tr>\n");
          }
          echo("</tbody>");
          echo"</table>\n";
        ?>
        <!-- End of table -->
      </div>
    </div>
    <a href="mainmenu.php"><button type="button" class="btn btn-primary btn-lg" style="background-color: #DE4C0D; padding: 10px 20px; cursor: pointer; display: flex; justify-content: left; align-items: center; border-radius: 5px; position: absolute; top: 5%; right: 2%">Back to Main Menu</button></a>
  </body>
</html>
