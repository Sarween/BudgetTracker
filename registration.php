<?php
require_once "pdo.php";
session_start();
$db_handle = new DBController();

if (isset($_POST['username']) && isset($_POST['password'])) {

  $username = htmlentities($_POST['username']);
  $password = htmlentities($_POST['password']);
  $password2 = htmlentities($_POST['password2']);

  $hashPassword = md5($password);

  if (strlen($username) < 1) {
    $_SESSION['failure'] = "Username is required";
    header("Location: registration.php");
    return;
  }
  else if (strlen($password) < 1) {
    $_SESSION['failure'] = "Password is required";
    header("Location: registration.php");
    return;
  }
  else if (strlen($password2) < 1) {
    $_SESSION['failure'] = "Repeat your password";
    header("Location: registration.php");
    return;
  }
  else if ($password != $password2) {
    $_SESSION['failure'] = "Password does not match";
    header("Location: registration.php");
    return;
  }
  else if(!isset($_SESSION['failure'])){
    $db = new DBController();
    $stmt = $db->getDB()->prepare("SELECT username FROM users WHERE username = :un");
    $stmt->bindParam(':un', $username);
    $stmt->execute();

    if($stmt->rowCount() > 0){
      $_SESSION['failure'] = "Username already taken";
      header("Location: registration.php");
      return;
    } else {
        $db = new DBController();
        $stmt = $db->getDB()->prepare('INSERT INTO users (userID, username, password) VALUES ("", :un, :pw)');
        $stmt->execute(array(
          ':un' => $username,
          ':pw' => $hashPassword)
        );
        //Print success message
        $_SESSION['success'] = "Account registered successfully";
        header("Location: registration.php");
        return;
      }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
  $(document).ready(function(){
     $("#username").keyup(function(){
        var username = $(this).val().trim();
        if(username != ''){
           $.ajax({
              url: 'ajaxfile.php',
              type: 'post',
              data: {username: username},
              success: function(response){
                  $('#uname_response').html(response);
               }
           });
        }else{
           $("#uname_response").html("");
        }
      });
   });
  </script>
</head>

<body>
    <section class="vh-100" style="background-image: url('https://static.vecteezy.com/system/resources/previews/003/503/120/original/abstract-purple-trendy-background-cool-background-design-for-posters-vector.jpg');">
      <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-lg-12 col-xl-11">
            <div class="card text-black" style="border-radius: 25px;">
              <div class="card-body p-md-5">
                <div class="row justify-content-center">
                  <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

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

                    <form class="mx-1 mx-md-4" method="POST">
                        <div class="text-center mb-5 mx-1 mx-md-4 mt-4" id="uname_response" ></div>
                      <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <input type="text" id="username" class="form-control" name="username" placeholder="Enter a username here"/>
                          <label class="form-label" for="form3Example1c">Create a username</label>
                        </div>
                      </div>

                      <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <input type="password" id="password" class="form-control" name="password" placeholder="Enter a password here"/>
                          <label class="form-label" for="form3Example4c">Create a password</label>
                        </div>
                      </div>

                      <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <input type="password" id="password2" class="form-control" name="password2" placeholder="Repeat your password here"/>
                          <label class="form-label" for="form3Example4cd">Repeat your password</label>
                        </div>
                      </div>

                      <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                        <button type="submit" class="btn btn-success btn-lg">Register</button>
                      </div>

                      <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                        <a href="login.php"><button type="button" class="btn btn-primary btn-lg">Back to Login Page</button></a>
                      </div>
                    </form>
                  </div>

                  <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                    <img src="https://www.pngitem.com/pimgs/m/284-2840638_saving-money-in-bank-cartoon-hd-png-download.png"
                    class="img-fluid" alt="Sample image">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
  </html>
