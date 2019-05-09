<?php
class Brewery{

  // database connection and table name
  private $conn;
  private $table_name = "brewerys";

  // object properties
  private $id;
  private $name;

  public function __construct($db){
      $this->conn = $db;
  }

  function readOne(){
    if (!empty($this->id)){
      $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id);
    } else {
      $query = "SELECT * FROM " . $this->table_name . " WHERE name LIKE :name LIMIT 0,1";
      $stmt = $this->conn->prepare($query);
      $this->name=htmlspecialchars(strip_tags($this->name));
      $stmt->bindParam(":name", $this->name);
    }
    if($stmt->execute()) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->id = $row['id'];
      $this->name = $row['name'];
      return true;
    } else {
      return false;
    }
  }

  // used by select drop-down list
  function readAll(){
    //select all data
    $query = "SELECT
                id, name
            FROM
                " . $this->table_name . "
            ORDER BY
                name";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  // used to read category name by its ID
  function readName(){

    $query = "SELECT name FROM " . $this->table_name . " WHERE id = ? limit 0,1";

    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->name = $row['name'];
  }

    // used for paging products
  public function countAll(){

    $query = "SELECT id FROM " . $this->table_name . "";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    $num = $stmt->rowCount();

    return $num;
  }

  public function getConn(){
    return $this->conn;
  }

  public function setConn($conn){
    $this->conn = $conn;
  }

  public function getTable_name(){
    return $this->table_name;
  }

  public function setTable_name($table_name){
    $this->table_name = $table_name;
  }

  public function getId(){
    return $this->id;
  }

  public function setId($id){
    $this->id = $id;
  }

  public function getName(){
    return $this->name;
  }

  public function setName($name){
    $this->name = $name;
  }
}
?>
