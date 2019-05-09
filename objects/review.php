<?php
class Review{

  // database connection and table name
  private $conn;
  private static $table_name = "reviews";

  // object properties
  private $id;
  private $user_id;
  private $beer_id;
  private $title;
  private $content;
  private $timestamp;
  private $rating;

  public function __construct($db){
      $this->conn = $db;
  }

  // create review
  function create(){
    //write query
    $query = "INSERT INTO
                " . Review::$table_name . "
            SET
                beer_id=:beer_id, user_id=:user_id, title=:title, content=:content, timestamp=:timestamp, rating=:rating";

    $stmt = $this->conn->prepare($query);

    // posted values
    $this->beer_id=htmlspecialchars(strip_tags($this->beer_id));
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $this->title=htmlspecialchars(strip_tags($this->title));
    $this->content=htmlspecialchars(strip_tags($this->content));
    $this->rating=htmlspecialchars(strip_tags($this->rating));
    $this->setTimestamp(date('Y-m-d G:i:s'));

    // bind values
    $stmt->bindParam(":beer_id", $this->beer_id);
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":content", $this->content);
    $stmt->bindParam(":rating", $this->rating);
    $stmt->bindParam(":timestamp", $this->timestamp);

    if($stmt->execute()){
      return true;
    }else{
      return false;
    }
  }

  // create review
  function update(){
    //write query
    $query = "UPDATE
                " . Review::$table_name . "
            SET
                beer_id=:beer_id, user_id=:user_id, title=:title, content=:content, timestamp=:timestamp, rating=:rating
            WHERE
                id=:id";

    $stmt = $this->conn->prepare($query);

    // posted values
    $this->beer_id=htmlspecialchars(strip_tags($this->beer_id));
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $this->title=htmlspecialchars(strip_tags($this->title));
    $this->content=htmlspecialchars(strip_tags($this->content));
    $this->rating=htmlspecialchars(strip_tags($this->rating));
    $this->setTimestamp(date('Y-m-d G:i:s'));
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind values
    $stmt->bindParam(":beer_id", $this->beer_id);
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":content", $this->content);
    $stmt->bindParam(":rating", $this->rating);
    $stmt->bindParam(":timestamp", $this->timestamp);
    $stmt->bindParam(":id", $this->id);

    if($stmt->execute()){
      return true;
    }else{
      return false;
    }
  }

  static function readAll($beer_id = null, $user_id = null,$db){
    //Selects all reviews either filtered by beer_id, user_id or unfiltered
    if (!empty($beer_id)){
      $query = "SELECT * FROM reviews WHERE beer_id = :beer_id";
      $stmt = $db->prepare($query);
      $stmt->bindParam(":beer_id", $beer_id);
    } elseif (!empty($user_id)) {
      $query = "SELECT * FROM " . Review::$table_name . " WHERE user_id = :user_id";
      $stmt = $db->prepare($query);
      $stmt->bindParam(":user_id", $user_id);
    } else {
      $query = "SELECT * FROM " . Review::$table_name;
      $stmt = $db->prepare($query);
    }
    if($stmt->execute()){
      $review_array = array();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $review = new Review($db);
        $review->setId($row['id']);
        $review->setUser_id($row['user_id']);
        $review->setBeer_id($row['beer_id']);
        $review->setTitle($row['title']);
        $review->setContent($row['content']);
        $review->setRating($row['rating']);
        $review->setTimestamp($row['timestamp']);
        $review_array[] = $review; //adds an element to the array
      }
      return $review_array;
    } else {
      return null;
    }
  }

  public static function getAVGRating($conn, $beer_id){
    $query = "SELECT AVG(rating) as avg_rating FROM reviews WHERE (beer_id=$beer_id)";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_NUM);
    return $row[0];
  }

  function readOne(){
    $query = "SELECT * FROM " . Review::$table_name . " WHERE beer_id = ? AND user_id = ? LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->beer_id);
    $stmt->bindParam(2, $this->user_id);

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $review->setId($row['id']);
    $review->setUser_id($row['user_id']);
    $review->setBeer_id($row['beer_id']);
    $review->setTitle($row['title']);
    $review->setContent($row['content']);
    $review->setRating($row['rating']);
    $review->setTimestamp($row['timestamp']);
  }

  function delete(){
    $query = "DELETE FROM " . Review::$table_name . " WHERE beer_id=:beer_id AND user_id=:user_id";
    $stmt = $this->conn->prepare($query);

    // bind values
    $stmt->bindParam(':beer_id', $this->beer_id);
    $stmt->bindParam(':user_id', $this->user_id);

    if ($stmt->execute()){
      return true;
    } else {
      return false;
    }
  }

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getUser_id(){
		return $this->user_id;
	}

	public function setUser_id($user_id){
		$this->user_id = $user_id;
	}

	public function getBeer_id(){
		return $this->beer_id;
	}

	public function setBeer_id($beer_id){
		$this->beer_id = $beer_id;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getContent(){
		return $this->content;
	}

	public function setContent($content){
		$this->content = $content;
	}

	public function getTimestamp(){
		return $this->timestamp;
	}

  public function setTimestamp($newTimestamp) {
    $this->timestamp = $newTimestamp;
  }

	public function getRating(){
		return $this->rating;
	}

	public function setRating($rating){
		$this->rating = $rating;
	}
}
?>
