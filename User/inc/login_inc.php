<?php
//Start session so that the user stays logged in
session_start();

if (isset($_POST['submit'])) {

include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/db.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/user.php';

    //instantiate database
    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $user->setUsername($username);
    if ($user->readOne($username)) {
      // password_verify($password, $user->getpassword()) returns true or false
      $hashedPassword = password_verify($password, $user->getpassword());
      if ($hashedPassword == false) {
        header("Location: ../../index.php?login=password");
        exit();
      } elseif ($hashedPassword == true){
        // login user
        $user_ID = $user->getId();
        $_SESSION['session_id'] = $user_ID;
        header("Location: ../../index.php");
        //TODO
        //header('Location: ' . $_SESSION['LastPage']);
        exit;
      }
    } else {
        // ?login=user gives the information to index.php
        //header("Location: ../../error.php?errorcode=1");
        echo "falsch";
        exit();
    }

} else {
    header('Location: ' . $_SESSION['LastPage']);
    exit();
}
