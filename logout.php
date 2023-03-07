<?php
session_start();

require "Util.php";
$util = new Util();

//Clear Session
$_SESSION["userID"] = "";
session_destroy();

// clear cookies
$util->clearAuthCookie();

header('location:login.php');
?>
