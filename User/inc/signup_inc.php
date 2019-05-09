<?php
//If so that nothing will happen if the user enters the URL
if (isset($_POST['submit'])) {
  include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/db.php';
  include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Objects/user.php';

  //instantiate database and user
  $database = new Database();
  $db = $database->getConnection();
  $user = new user($db);

  //Set attributes of the new user object
  $user->setFirstname($_POST['firstname']);
  $user->setLastname($_POST['lastname']);
  $user->setEmail($_POST['email']);

  if ($user->isUsernameValid($_POST['username'])) {
    $user->setUsername($_POST['username']);
  } else {
    //invalid username message
    header("Location: ../signup.php");
    exit();
  }

  //Encode Password for safer handeling
  $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
  $user->setpassword($password);

  if ($user->create()) {
    //registration successful message

    // login user
    session_start();
    $user_ID = $user->getId();
    $_SESSION['session_id'] = $user_ID;
    header("Location: ../../index.php");
    exit;
  } else {
    //registration failed message
    echo "failed";
  }
} else {
  //This will redirect to the signup page, if the site was called other
  //than the expected way
  header("Location: ../signup.php");
  exit();
}
?>
