<?php
session_start();

require_once "Auth.php";
require_once "Util.php";

$auth = new Auth();
$db_handle = new DBController();
$util = new Util();

require_once "authCookieSessionValidate.php";

if ($isLoggedIn) {

    $util->redirect("mainmenu.php");
}

if (!empty($_POST["login"])) {
    $isAuthenticated = false;

    $username = htmlentities($_POST["username"]);
    $password = htmlentities($_POST["password"]);
    $hashPassword = md5($password);

    $db = new DBController();
    $stmt = $db->getDB()->prepare("SELECT username FROM users WHERE username = :un");
    $stmt->bindParam(':un', $username);
    $stmt->execute();

    if($stmt->rowCount() == 0){
      $_SESSION['failure'] = "Username not registered";
      header("Location: login.php");
      return;
    }
    else {
      $user = $auth->getMemberByUsername($username);

    if ($hashPassword == $user[0]["password"]) {
        $isAuthenticated = true;
      }

    if ($isAuthenticated) {
        $_SESSION["userID"] = $user[0]["userID"];
        $_SESSION["username"] = $user[0]["username"];
        // Set Auth Cookies if 'Remember Me' checked
        if (!empty($_POST["remember"])) {
            setcookie("member_login", $username, $cookie_expiration_time);

            $random_password = $util->getToken(16);
            setcookie("random_password", $random_password, $cookie_expiration_time);

            $random_selector = $util->getToken(32);
            setcookie("random_selector", $random_selector, $cookie_expiration_time);

            $random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
            $random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);

            $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);

            // mark existing token as expired
            $userToken = $auth->getTokenByUsername($username, 0);

            if (!empty($userToken[0]["id"])) {
                $auth->markAsExpired($userToken[0]["id"]);
            }
            // Insert new token
            $auth->insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date);
        } else {
            $util->clearAuthCookie();
        }
        $util->redirect("mainmenu.php");
    } else {
        $_SESSION['failure'] = "Invalid Password";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script type="text/javascript">
	   function validateForm() {
		     if (document.loginForm.username.value == null || document.loginForm.username.value == "") {
			       alert("Please key-in username");
			       return false;
		     }
		     if (document.loginForm.password.value == null || document.loginForm.password.value == "") {
		       	alert("Please key-in password");
			     return false;
		     }
	    }
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

                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Login</p>

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

                    <form action="" class="mx-1 mx-md-4" method="POST" name="loginForm" onSubmit="return validateForm()">
                      <div class="error-message"><?php if(isset($message)) { echo $message; } ?></div>
                      <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <input type="text" id="username" class="form-control" placeholder="Enter your username here" name="username" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>"/>
                          <label class="form-label" for="form3Example1c">Enter Username</label>
                        </div>
                      </div>

                      <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <input type="password" id="password" class="form-control" placeholder="Enter your password here" name="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>"/>
                          <label class="form-label" for="form3Example4c">Enter Password</label>
                        </div>
                      </div>

                      <div class="form-check d-flex justify-content-center mb-5">
                        <input type="checkbox" name="remember" id="remember"
                        <?php if(isset($_COOKIE["member_login"])) { ?> checked
                        <?php } ?> />
                        <label class="form-check-label" for="remember-me">Remember Me</label>
                      </div>

                      <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                        <button type="submit" class="btn btn-primary btn-lg" name="login" value="Login">Login</button>
                      </div>

                      <div class="form-check d-flex justify-content-center mb-5">
                        <label class="form-check-label" for="form2Example3">
                          Don't have an account? <a href="registration.php">Register</a>
                        </label>
                      </div>

                    </form>

                  </div>
                  <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                    <img src="https://www.actitime.com/wp-content/uploads/2020/04/7-steps-to-efficient-cost-tracking.png"
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
