<?php
class Beer_Ingredient{
  // database connection and table name
  private $conn;
  private $table_name = "beers_ingredients";

  private $id;
  private $beer_id;
  private $ingredient_id;

  public function __construct($db){
    $this->conn = $db;
  }

  public function create(){
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                beer_id=:beer_id, ingredient_id=:ingredient_id";

    $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

    $stmt = $this->conn->prepare($query);

    // posted values
    $this->beer_id=htmlspecialchars(strip_tags($this->beer_id));
    $this->ingredient_id=htmlspecialchars(strip_tags($this->ingredient_id));


    // bind values
    $stmt->bindParam(":beer_id", $this->beer_id);
    $stmt->bindParam(":ingredient_id", $this->ingredient_id);

    echo "\nPDO::errorInfo():\n";
    print_r($this->conn->errorInfo());

    if($stmt->execute()){
      return true;
    }else{
      return false;
    }
  }
  
  static function readAll($beer_id = null, $ingredient_id = null, $db){
    if (!empty($beer_id)){
      $query = "SELECT * FROM beers_ingredients WHERE beer_id = ?";
      $stmt = $db->prepare($query);
      $stmt->bindParam(1, $beer_id);
    }
    if($stmt->execute()) {
      $beer_ingredient_array = array();
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $beer_ingredient = new Beer_Ingredient($db);
        $beer_ingredient->setBeer_id($row['beer_id']);
        $beer_ingredient->setIngredient_id($row['ingredient_id']);
        $beer_ingredient_array[] = $beer_ingredient;
      }

      return $beer_ingredient_array;
    }
  }

  function readIngredientId(){

    $query = "SELECT ingredient_id FROM " . $this->table_name . " WHERE beer_id = ? limit 0,1";

    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->beer_id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->ingredient_id = $row['ingredient_id'];
  }

  public function setId($newId){
    $this->id = $newId;
  }

  public function setBeer_id($newBeer_id){
    $this->beer_id = $newBeer_id;
  }

  public function setIngredient_id($newIngredient_id){
    $this->ingredient_id = $newIngredient_id;
  }

  public function getId(){
    return $this->id;
  }

  public function getBeer_id(){
    return $this->beer_id;
  }

  public function getIngredient_id(){
    return $this->ingredient_id;
  }
}

?>
