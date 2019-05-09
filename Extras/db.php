<?php
class database {
  private $host = "localhost";
  private $db_name = "hopfenspeicher";
  private $username = "root";
  private $password = "";
  public $connection;

  //Verbindung zur Datenbank aufbauen und diese zurückgeben
  function getConnection () {
    $this->connection = null;

    try{
      $this->connection = new PDO("mysql:host=$this->host;dbname=$this->db_name;charset=utf8", $this->username, $this->password);
    }catch(PDOException $exception){
      echo "Connection error: " . $exception->getMessage();
    }

    return $this->connection;
  }
}
?>
