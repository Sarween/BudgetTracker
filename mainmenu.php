<?php
    session_start();
    require_once "authCookieSessionValidate.php";

    if(!$isLoggedIn) {
        header('location:login.php');
    }
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Main Menu</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="50">
  <nav class="navbar navbar-expand-md ">
    <h2 style="color:white">Welcome, <?php echo ($_SESSION['username']); ?></h2>

    <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" onclick="window.location.href='https://www.thebalance.com/how-to-make-a-budget-1289587'">How to make a personal budget</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="window.location.href='https://docs.google.com/document/d/1RwdklM1x0X9GLllZ8Z-nat-4EQyx5-u6w6Ss9vSDvr8/edit?usp=sharing'">How to use this system</a>
        </li>
        <li class="nav-item">
          <a href="logout.php"><button type="button" class="btn btn-warning btn-lg">Logout</button></a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Carousel -->
  <div id="slide" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <!-- The slideshow -->
    <div class="carousel-inner ">
      <div class="carousel-item active ad1">
        <div class="overlay"></div>
        <img src="https://www.thebalance.com/thmb/uHFpzkmaKDIaE-gPFexJyZ7snL8=/1500x1000/filters:fill(auto,1)/how-to-make-a-budget-1289587-Final2-updated-17bbe4528d38430ca42f4138f599ed56.png" alt="Penang">
        <div class="carousel-caption">
          <header class="page-header header container-fluid">
            <div class="description">
              <p>If you want to control your spending and work toward your financial goals, you need a budget.</p>
            </div>
          </header>
        </div>
      </div>

      <div class="carousel-item">
        <div class="overlay"></div>
        <img src="https://www.thebalance.com/thmb/4Ijw8xRy7woDIngKJw-NB-36Kw4=/2667x2000/smart/filters:no_upscale()/what-makes-for-a-successful-budget-1289233_final-e4113f80d04442e18e3b6995561820c5.png" alt="Kek Lok Si">
        <div class="carousel-caption">
          <header class="page-header header container-fluid">
            <div class="description">
              <p>Always learn to keep track of your expenses.</p>
            </div>
        </header>
      </div>
      </div>

      <div class="carousel-item">
        <div class="overlay"></div>
        <img src="https://www.wikihow.com/images/thumb/0/05/Budget-Your-Money-Step-13-Version-5.jpg/v4-460px-Budget-Your-Money-Step-13-Version-5.jpg" alt="Little India">
        <div class="carousel-caption">
          <header class="page-header header container-fluid">
            <div class="description">
              <p>Set a limit before you start spending your money</p>
            </div>
        </header>
      </div>
      </div>
    </div>

  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#slide" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#slide" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>

  <ul class="carousel-indicators">
    <li data-target="#slide" data-slide-to="0" class="active"></li>
    <li data-target="#slide" data-slide-to="1"></li>
    <li data-target="#slide" data-slide-to="2"></li>
  </ul>
</div>
    </div>
      <a href="Transaction.php"><button type="button" class="btn btn-primary btn-lg" style="background-color: #DE4C0D; padding: 10px 20px; cursor: pointer; display: flex; justify-content: left; align-items: center; border-radius: 5px; position: absolute; bottom: 3%; right: 41.5%">Take Me to Transaction Page</button></a>
  <script src="main.js"></script>
</body>
</html>
