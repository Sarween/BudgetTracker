<?php

include 'pdo.php';
$db = new DBController();

if(isset($_POST['username'])){
   $username = htmlentities($_POST['username']);
   $stmt = $db->getDB()->prepare("SELECT count(*) as cntUser FROM users WHERE username=:un");
   $stmt->bindValue(':un', $username, PDO::PARAM_STR);
   $stmt->execute();
   $count = $stmt->fetchColumn();

   $response = "<span style='color: green;'>Username Available.</span>";
   if($count > 0){
      $response = "<span style='color: red;'>Username Not Available.</span>";
   }
   echo $response;
   exit;
 }
