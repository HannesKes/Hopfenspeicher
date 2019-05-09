<?php
class Image{

  // database connection and table name
  private $conn;
  private $table_name = "images";

  // object properties
  private $id;
  private $imgdata;
  private $imgtype;

  public function __construct($db){
      $this->conn = $db;
  }

  // create product
  function create(){

    //write query
    $query = "INSERT INTO " . $this->table_name . " SET imgdata=:imgdata, imgtype=:imgtype";

    $stmt = $this->conn->prepare($query);

    // posted values
    //$this->setImgdata(htmlspecialchars(strip_tags($this->getImgData())));
    //$this->setImgtype(htmlspecialchars(strip_tags($this->getImgType())));


    // bind values
    $stmt->bindParam(":imgdata", $this->imgdata);
    $stmt->bindParam(":imgtype", $this->imgtype);

    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
  }

  function readAll($from_record_num, $records_per_page){

    $query = "SELECT
                id, imgdata, imgtype
            FROM
                " . $this->table_name . "
            ORDER BY
                name ASC
            LIMIT
                {$from_record_num}, {$records_per_page}";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    return $stmt;
  }

  // used for paging products
  public function countAll(){
    $query = "SELECT id FROM " . $this->table_name . "";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    $num = $stmt->rowCount();

    return $num;
  }

  function readOne(){
    $query = "SELECT imgdata, imgtype FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->setImgdata($row['imgdata']);
    $this->setImgtype($row['imgtype']);
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

  public function getImgdata(){
    return $this->imgdata;
  }

  public function setImgdata($imgdata){
    $this->imgdata = $imgdata;
  }

  public function getImgtype(){
    return $this->imgtype;
  }

  public function setImgtype($imgtype){
    $this->imgtype = $imgtype;
  }
}
?>
