<?php
class User {
  //database connection and table name
  private $connection;
  private $table_name = "users";

  //attributes
  private $id;
  private $firstname;
  private $lastname;
  private $username;
  private $email;
  private $description;
  private $favbeer_id;
  private $password;
  private $image;
  private $passwordcode;
  private $timestamp;

  function __construct($db) {
    $this->connection = $db;
  }

  //reads single user from db using the ID attribute
  //and updating the attributes of the object
  function readOne() {
    if (!empty($this->id)){
      $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? limit 0,1";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(1, $this->id);
    } elseif (!empty($this->username)) {
      $query = "SELECT * FROM " . $this->table_name . " WHERE username LIKE :username limit 0,1";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(":username", $this->username);
    } elseif (!empty($this->email)) {
      $query = "SELECT * FROM " . $this->table_name . " WHERE email LIKE :email limit 0,1";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(":email", $this->email);
    } else {
      return false;
    }
    if($stmt->execute()){
      $count = $stmt->rowCount();
      if($count == 0){
        return false;
      }
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->setId($row['id']);
      $this->setFirstname($row['firstname']);
      $this->setLastname($row['lastname']);
      $this->setUsername($row['username']);
      $this->setEmail($row['email']);
      $this->setDescription($row['description']);
      $this->setFavBeer_ID($row['favbeer_id']);
      $this->setpassword($row['password']);
      $this->setImage($row['image']);
      $this->setPasswordcode($row['passwordcode']);
      $this->setTimestamp($row['timestamp']);
      return true;
    } else {
      return false;
    }
  }

  //Creates a new user in the database
  function create() {
    $query = "INSERT INTO " . $this->table_name . " SET firstname=:firstname, lastname=:lastname, username=:username, email=:email, password=:password, timestamp=:timestamp";
    //, image=:image In der Zukunft
    $stmt = $this->connection->prepare($query);

    $this->setFirstname(htmlspecialchars(strip_tags($this->firstname)));
    $this->setLastname(htmlspecialchars(strip_tags($this->lastname)));
    $this->setUsername(htmlspecialchars(strip_tags($this->username)));
    $this->setEmail(htmlspecialchars(strip_tags($this->email)));
    $this->setpassword(htmlspecialchars(strip_tags($this->password)));
    $this->setTimestamp(date('Y-m-d G:i:s'));

    $stmt->bindParam(":firstname", $this->firstname);
    $stmt->bindParam(":lastname", $this->lastname);
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":timestamp", $this->timestamp);
    //$stmt->bindParam(":image", $this->image);

    if($stmt->execute()) {
        $user_ID = $this->connection->lastInsertId();
        $this->id = $user_ID;
        return true;
    } else {
        return false;
    }
  }

  //updates the DB using the attributes of the object
  function update() {
    $query = "UPDATE " . $this->table_name . " SET username=:username, firstname=:firstname, lastname=:lastname,
                                                    email=:email, description=:description, favbeer_id=:favbeer_id, image=:image,
                                                    passwordcode=:passwordcode, password=:password
                                                      WHERE id =:id";
    $stmt = $this->connection->prepare($query);

    // posted values
    $this->setUsername(htmlspecialchars(strip_tags($this->username)));
    $this->setFirstname(htmlspecialchars(strip_tags($this->firstname)));
    $this->setLastname(htmlspecialchars(strip_tags($this->lastname)));
    $this->setEmail(htmlspecialchars(strip_tags($this->email)));
    $this->setDescription(htmlspecialchars(strip_tags($this->description)));
    $this->setFavBeer_ID(htmlspecialchars(strip_tags($this->favbeer_id)));
    $this->setPasswordcode(htmlspecialchars(strip_tags($this->passwordcode)));

    // bind parameters
    $stmt->bindParam(':username', $this->username);
    $stmt->bindParam(':firstname', $this->firstname);
    $stmt->bindParam(':lastname', $this->lastname);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':favbeer_id', $this->favbeer_id);
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(":image", $this->image);
    $stmt->bindParam(":passwordcode", $this->passwordcode);
    $stmt->bindParam(":password", $this->password);

    // execute the query
    if($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  //checks the database for multiple criteria the username has to
  //match to be a valid username
  function isUsernameValid($username) {
    //Check if the username already exists in the database
    $query = "SELECT id FROM " . $this->table_name . " WHERE username LIKE \"$username\" limit 0,1";
    $stmt = $this->connection->prepare($query);
    $stmt->execute();
    if($stmt->rowCount() > 0) {
      //TODO: check einbauen ob der name der gleiche wie der des angemeldeten nutzers ist
      return false;
    }

    //Check if the username contains spaces
    if(strpos($username, ' ') !== false) {
      return false;
    }

    return true;
  }
  //returns an Array containing all User objects with values from the Database.
  //The Array is limited by the $from_record_num and $records_per_page parameters.
  static function readAll($from_record_num, $records_per_page, $db) {
    $query = "SELECT id From users LIMIT {$from_record_num}, {$records_per_page}";

    $stmt = $db->prepare($query);
    $stmt->execute();

    $user_array = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $user = new User($db);
      $user->setId($row['id']);
      $user->readOne();
      $user_array[] = $user; //adds an element to the array
    }

    return $user_array;
  }

  // used for paging users
  function countAll(){
    $query = "SELECT id FROM " . $this->table_name . "";

    $stmt = $this->connection->prepare($query);
    $stmt->execute();

    $num = $stmt->rowCount();

    return $num;
  }

  //Getter methods
  function getId() {
    return $this->id;
  }
  function getFirstname() {
    return $this->firstname;
  }
  function getLastname() {
    return $this->lastname;
  }
  function getUsername() {
    return $this->username;
  }
  function getEmail() {
    return $this->email;
  }
  function getDescription() {
    return $this->description;
  }
  function getFavBeer_ID() {
    return $this->favbeer_id;
  }
  function getpassword() {
    return $this->password;
  }
  function getImage(){
    return $this->image;
  }
  function getPasswordcode(){
    return $this->passwordcode;
  }
  function getTimestamp(){
    return $this->timestamp;
  }

  public function getFullImagePath(){
    if(($this->getImage() != '') AND (file_exists('../uploads/' . $this->getImage()))){
      $image = '/Hopfenspeicher/uploads/' . $this->getImage();
    } else {
      $image = "/Hopfenspeicher/Assets/user_empty.png";
    }
    return $image;
  }
  //End of getters

  //Setter methods
  function setId($newId) {
    $this->id = $newId;
  }
  function setFirstname($newFirstname) {
    $this->firstname = $newFirstname;
  }
  function setLastname($newLastname) {
    $this->lastname = $newLastname;
  }
  function setUsername($newUsername) {
    $this->username = $newUsername;
  }
  function setEmail($newEmail) {
    $this->email = $newEmail;
  }
  function setDescription($newDescription) {
    $this->description = $newDescription;
  }
  function setFavBeer_ID($newFavBeer_ID) {
    $this->favbeer_id = $newFavBeer_ID;
  }
  function setpassword($newpassword) {
    $this->password = $newpassword;
  }
  function setImage($newImage) {
    $this->image = $newImage;
  }
  function setPasswordcode($newPasswordcode) {
    $this->passwordcode = $newPasswordcode;
  }
  function setTimestamp($newTimestamp) {
    $this->timestamp = $newTimestamp;
  }
  //End of setters
}
?>
