<?php
require "pdo.php";
class Auth {

      function getMemberByUsername($username) {
        $db_handle = new DBController();
        $query = "Select * from users where username = ?";
        $param1 = PDO::PARAM_STR;
        $result = $db_handle->runQuery($query, array($username), array($param1));
        return $result;
      }

	   function getTokenByUsername($username,$expired) {
       $db_handle = new DBController();
	      $query = "Select * from tbl_token_auth where username1 = ? and is_expired = ?";
        $param1 = PDO::PARAM_STR;
        $param2 = PDO::PARAM_INT;
	      $result = $db_handle->runQuery($query, array($username, $expired), array($param1, $param2));
	      return $result;
    }

    function markAsExpired($tokenId) {
        $db_handle = new DBController();
        $query = "UPDATE tbl_token_auth SET is_expired = ? WHERE id = ?";
        $expired = 1;
        $param = PDO::PARAM_INT;
        $result = $db_handle->update($query, array($expired, $tokenId), array($param, $param));
        return $result;
    }

    function insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date) {
        $db_handle = new DBController();
        $query = "INSERT INTO tbl_token_auth (username1, password_hash, selector_hash, expiry_date) values (?, ?, ?,?)";
        $param = PDO::PARAM_STR;
        $result = $db_handle->insert($query, array($username, $random_password_hash, $random_selector_hash, $expiry_date), array($param, $param, $param, $param));
        return $result;
    }

    function update($query) {
        $stmt = $this->conn->prepare($query);
        $stmt -> execute();
    }
}
?>
