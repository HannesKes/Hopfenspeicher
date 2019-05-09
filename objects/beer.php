<?php
class Beer{

  // database connection and table name
  private $conn;
  private $table_name = "beers";

  // filter for countAll()
  private $whereFilter;

  // object properties
  private $id;
  private $name;
  private $brewery_id;
  private $description;
  private $type_id;
  private $alcstrength;
  private $ingredients;
  private $image;

  public function __construct($db){
    $this->conn = $db;
  }

  // create beer
  function create(){
    //write query
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, brewery_id=:brewery_id, description=:description, type_id=:type_id, alcstrength=:alcstrength, image=:image";
    $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    $stmt = $this->conn->prepare($query);

    // posted values
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->brewery_id=htmlspecialchars(strip_tags($this->brewery_id));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->type_id=htmlspecialchars(strip_tags($this->type_id));
    $this->alcstrength=htmlspecialchars(strip_tags($this->alcstrength));
    $this->image=htmlspecialchars(strip_tags($this->image));

    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":brewery_id", $this->brewery_id);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":type_id", $this->type_id);
    $stmt->bindParam(":alcstrength", $this->alcstrength);
    $stmt->bindParam(":image", $this->image);

    if($stmt->execute()){
      $this->id = $this->conn->lastInsertId();
      return true;
    }else{
      return false;
    }
  }

  function readAll($from_record_num, $records_per_page, $sort = null, $filter = null){

    // echo "<br/>";
    //
    // foreach ($filter as $key => $value) {
    //   echo $key . " = " . $value . "<br/>";
    // }

    // select sorting
    if (isset($sort)){
      switch ($sort) {
        case 'bezAsc':
          $order = "name ASC";
          break;

        case 'bezDesc':
          $order = "name DESC";
          break;

        case 'alkAsc':
          $order = "alcstrength ASC";
          break;

        case 'alkDesc':
          $order = "alcstrength DESC";
          break;

        default:
          $order = "name ASC";
          break;
      }
    } else {
      $order = "name ASC";
    }

    $this->whereFilter = "";

    // put brewery into where-clausel
    if (isset($filter['filterBrew'])){
      $this->whereFilter = "WHERE brewery_id = '" . $filter['filterBrew'] . "'";
    }

    // put type into where-clausel
    if (isset($filter['filterType'])){
      if (strlen($this->whereFilter)==0){
        $this->whereFilter = "WHERE type_id = '" . $filter['filterType'] . "'";
      } else {
        $this->whereFilter = $this->whereFilter . " AND type_id = \"" . $filter['filterType'] . "\"";
      }
    }

    // put minimum alcstrength into where-clausel
    if (isset($filter['filterAlcLow'])){
      if (strlen($this->whereFilter)==0){
        $this->whereFilter = "WHERE type_id = '" . $filter['filterAlcLow'] . "\"";
      } else {
        $this->whereFilter = $this->whereFilter . " AND alcstrength = \"" . $filter['filterAlcLow'] . "\"";
      }
    }

    // put maximum alcstrength into where-clausel
    if (isset($filter['filterAlcHigh'])){
      if (strlen($this->whereFilter)==0){
        $this->whereFilter = "WHERE type_id = '" . $filter['filterAlcHigh'] . "'";
      } else {
        $this->whereFilter = $this->whereFilter . " AND alcstrength = \"" . $filter['filterAlcHigh'] . "\"";
      }
    }

    // if (isset($filter['filterBrew']) and isset($filter['filterType'])){
    //   $this->whereFilter = "WHERE brewery_id = '" . $filter['filterBrew'] . "' AND type_id = '" . $filter['filterType'] . "'";
    // } else if (isset($filter['filterBrew'])){
    //   $this->whereFilter = "WHERE brewery_id = '" . $filter['filterBrew'] . "'";
    // } else if (isset($filter['filterType'])){
    //   $this->whereFilter = "WHERE type_id = '" . $filter['filterType'] . "'";
    // }


    $query = "SELECT
                id, name, brewery_id, description, type_id, alcstrength, image
            FROM
                " . $this->table_name . "
                " . $this->whereFilter . "
            ORDER BY
                " . $order . "
            LIMIT
                {$from_record_num}, {$records_per_page}";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    //echo " Query: " .$query;
    //echo " Anzahl Biere: " . $stmt->rowCount();

    return $stmt;

  }

  // used for paging products
  public function countAll(){
    $query = "SELECT id FROM " . $this->table_name . " " . $this->whereFilter . "";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    $num = $stmt->rowCount();

    //echo "query: " . $query;
    //echo "num: " . $num;

    return $num;
  }

  function readOne(){
    if (!empty($this->id)){
      $query = "SELECT id, name, brewery_id, description, type_id, alcstrength, image FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id);
    } else {
      $query = "SELECT id, name, brewery_id, description, type_id, alcstrength, image FROM " . $this->table_name . " WHERE name LIKE :name LIMIT 0,1";
      $stmt = $this->conn->prepare($query);
      $this->name=htmlspecialchars(strip_tags($this->name));
      $stmt->bindParam(":name", $this->name);
    }
    if($stmt->execute()) {
      $count = $stmt->rowCount();
      if($count == 0){
        return false;
      }
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->id = $row['id'];
      $this->name = $row['name'];
      $this->brewery_id = $row['brewery_id'];
      $this->description = $row['description'];
      $this->type_id = $row['type_id'];
      $this->alcstrength = $row['alcstrength'];
      $this->image = $row['image'];
      $this->id = $row['id'];
      return true;
    } else {
      return false;
    }
  }

  static function lowestAlcStrength($db){
    $query = "SELECT alcstrength FROM beers ORDER BY alcstrength ASC LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['alcstrength'];
  }

  static function highestAlcStrength($db){
    $query = "SELECT alcstrength FROM beers ORDER BY alcstrength DESC LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['alcstrength'];
  }

  static function randomBeerName($db){
    $query = "SELECT name FROM beers ORDER BY RAND() LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['name'];
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

  public function getBrewery(){
    return $this->brewery_id;
  }

  public function setBrewery($brewery_id){
    $this->brewery_id = $brewery_id;
  }

  public function getDescription(){
    return $this->description;
  }

  public function setDescription($description){
    $this->description = $description;
  }

  public function getType_id(){
    return $this->type_id;
  }

  public function setType_id($type_id){
    $this->type_id = $type_id;
  }

  public function getAlcstrength(){
    return $this->alcstrength;
  }

  public function setAlcstrength($alcstrength){
    $this->alcstrength = $alcstrength;
  }

  public function getIngredients(){
    return $this->ingredients;
  }

  public function setIngredients($ingredients){
    $this->ingredients = $ingredients;
  }

  public function getImage(){
    return $this->image;
  }

  public function setImage($image){
    $this->image = $image;
  }

  public function getFullImagePath(){
    if(($this->getImage() != '') AND (file_exists('../uploads/' . $this->getImage()))){
      $image = '/Hopfenspeicher/uploads/' . $this->getImage();
    } else {
      $image = "/Hopfenspeicher/Assets/no_picture_beer.png";
    }
    return $image;
  }
}
?>
