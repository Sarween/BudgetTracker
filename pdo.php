<?php

class DBController{
  private $host = "localhost";
  private $user = "root";
  private $password = "";
  private $database = "BudgetTracker";
  private $conn;

    function __construct(){
      try{
        $this->conn = new PDO("mysql:host=$this->host;port=3306;dbname=$this->database", $this->user, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      }catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }

    }

    function getDB() {
      return $this->conn;
    }

    function runBaseQuery($query) {
      $result = $this->conn->$query;
      while($row=$result->fetch(PDO::FETCH_ASSOC)) {
        $resultset[] = $row;
        }
        if(!empty($resultset))
          return $resultset;
    }

    function runQuery($query, $param_value_array, $param_type) {
        $sql = $this->conn->prepare($query);
        if (count($param_type)>1){
          $sql->bindParam(1, $param_value_array[0], $param_type[0]);
          $sql->bindParam(2, $param_value_array[1], $param_type[1]);
          $sql->execute();
        }else{
          $sql->bindParam(1, $param_value_array[0], $param_type[0]);
          $sql->execute();
        }
          while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $resultset[] = $row;
            }
        if(!empty($resultset)) {
            return $resultset;
        }
    }

    function bindQueryParams($sql, $param_value_array, $param_type) {
        for($i=0; $i<count($param_type); $i++) {
          $num = $i+1;
          $value = $param_value_array[$i];
          $type = $param_type[$i];
          $sql -> bindParam($num, $value, $type);
        }
    }

    function insert($query, $param_value_array, $param_type) {
        $sql = $this->conn->prepare($query);
        $sql->bindParam(1, $param_value_array[0], $param_type[0]);
        $sql->bindParam(2, $param_value_array[1], $param_type[1]);
        $sql->bindParam(3, $param_value_array[2], $param_type[2]);
        $sql->bindParam(4, $param_value_array[3], $param_type[3]);
        $sql->execute();
    }

    function update($query, $param_value_array, $param_type) {
        $sql = $this->conn->prepare($query);
        $sql->bindParam(1, $param_value_array[0], $param_type[0]);
        $sql->bindParam(2, $param_value_array[1], $param_type[1]);
        $sql->execute();
    }
}
?>
