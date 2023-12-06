
<?php

class Database {
  public $conn;

     private $servername = "localhost";
     private $username = "root";
     private $password = "";
     private $dbname = "dbmovie";
  function __construct(){    
      
      try {
        $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname",$this->username,$this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        

      } catch(PDOException $e) {
            die($e->getMessage());
      }
      
      
  }    
  public static function getConnection() { 
    return (new Database)->conn;

}}
?>