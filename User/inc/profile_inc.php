<?php
  include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Objects/beer.php';
  include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Objects/review.php';
  include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/db.php';
  include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/images.php';

  //instantiate database and user
  $database = new Database();
  $db = $database->getConnection();
  $profileUser = new User($db);
  $beer = new Beer($db);
  $review = new Review($db);

  //find User ID with the username from the URL
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $profileUser->setId($id);
  } elseif (isset($_GET['User'])){
    $name = urldecode($_GET['User']);
    $profileUser->setUsername($name);
  } else {
    header("Location: $redirect_page");
  }
  // read the details of beer to be read
  if(!$profileUser->readOne()){
    //if you dont find one you get redirected
    header("Location: $redirect_page");
  }

  //Get user values from database
  $User_ID = $profileUser->getId();
  $firstname = $profileUser->getFirstname();
  $lastname = $profileUser->getLastname();
  $username = $profileUser->getUsername();
  $email = $profileUser->getEmail();
  $description = $profileUser->getDescription();
  $favbeer_id = $profileUser->getFavBeer_ID();

  $image = $profileUser->getFullImagePath();

  //Finds the favourite beer using the favbeer_Id
  $favBeer_name = null;
  if ($favbeer_id != 0) {
    $beer->setId($favbeer_id);
    if($beer->readOne()){
      $favBeer_name = $beer->getName();
    }
  }

  //Set ownProfile to true if the logged in user is on his own site
  $ownProfile = false;
  if (isset($_SESSION['session_id'])) {
    $loggedUser_ID = $_SESSION['session_id'];
    if ($User_ID == $loggedUser_ID) {
      $ownProfile = true;
    } else {
      $ownProfile = false;
    }
  }

  //controls toggle of $edit
  $edit = false;
  if (isset($_POST['edit']) ) {
    $edit = true;
  }

  function deleteImage(User $profileUser){
    $profileUser->setImage(null);
    $profileUser->update();
    header("Location: ?User=". $profileUser->getUsername());
  }

  //save changes functionality
  function saveChanges(user $profileUser) {
    $edit = false;
    //checks if the username has been changed by the user and if the username
    //fits the criteria for a valid username. If not it displays a warning
    if (isset($_POST['username']) && !empty($_POST['username'])) {
      if ($profileUser->getUsername() != $_POST['username']) {
        if ($profileUser->isUsernameValid($_POST['username'])) {
          $profileUser->setUsername($_POST['username']);
        } else {
          throw new Exception('Die Änderungen konnten nicht übernommen werden. Bitte wähle einen verfügbaren Benutzernamen.');
        }
      }
    }
    else if (empty($_POST['username'])) {
      throw new Exception('Die Änderungen konnten nicht übernommen werden. Der Benutzername darf nicht leer sein.');
    }
    if (isset($_POST['firstname']) ) {
      $profileUser->setFirstname($_POST['firstname']);
    }
    if (isset($_POST['lastname']) ) {
      $profileUser->setLastname($_POST['lastname']);
    }
    if (isset($_POST['email']) ) {
      $profileUser->setEmail($_POST['email']);
    }
    if (isset($_POST['description']) ) {
      $profileUser->setDescription($_POST['description']);
    }
    if (isset($_POST['favBeer']) ) {
      //subject to change
      $profileUser->setFavBeer_ID($_POST['favBeer']);
    }

    //update the user with the set attributes
    if($profileUser->update()){
      header("Location: ?User=". $profileUser->getUsername());
    }

  }

  //delete the review with the set attributes
  function deleteReview($db, $beer_id, $user_id){
    $review = new Review($db);
    $review->setBeer_id($beer_id);
    $review->setUser_id($user_id);
    $review->delete();
    header("Location: ".$_SERVER['REQUEST_URI']);
  }
?>
