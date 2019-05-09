<?php
session_start();
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/db.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Objects/user.php';

$loggedin = false;
$showPageTitle = false;

//instantiate database and user if a user is logged in
if (isset($_SESSION['session_id'])) {
  $database = new Database();
  $db = $database->getConnection();
  $loggedin_user = new user($db);
  $loggedin_user->setId($_SESSION['session_id']);
  $loggedin = true;
}

if((($redirect_when_loggedin == true) && ($loggedin == true)) OR
  (($redirect_when_loggedout == true) && ($loggedin == false))){
  header("Location: $redirect_page");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $page_title; ?></title>

    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Hopfenspeicher/Style/customStyle.css">

    <style type="text/css">
        .jumbotron {
      background-image: url('/Hopfenspeicher/Assets/Bier8.jpg');
      background-size: cover;}
    </style>
</head>
<body>

  <div class="jumbotron text-center" style="margin-bottom:0">
    <h1>Der Hopfenspeicher</h1>
    <p>Auch Wasser wird zum edlen Tropfen, mischt man es mit Malz und Hopfen.</p>
  </div>

  <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
    <a class="navbar-brand" href="/Hopfenspeicher/">Hopfenspeicher</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/Hopfenspeicher/index.php">Startseite</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/Hopfenspeicher/beer">Bier Übersicht</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/Hopfenspeicher/beer/randomBeer.php">Zufallsbier</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/Hopfenspeicher/User/index.php">Biernutzerübersicht</a>
        </li>
      </ul>

      <!-- Hiermit kann später eine Suche eingebunden werden.
      <form class="form-inline ml-auto" action="/action_page.php">
      <input class="form-control mr-sm-2" type="text" placeholder="Suche">
      <button class="btn btn-success" type="submit">Suche</button>
      </form>
      -->

    <!-- Login/Logout Button -->
      <ul class="navbar-nav ml-auto">
      <?php
        if ($loggedin == true) {
          $loggedin_user->readOne();
          $profile_image = $loggedin_user->getImage();
          if(($profile_image != '') AND (file_exists($_SERVER['DOCUMENT_ROOT']. "/Hopfenspeicher/uploads/" . $profile_image))){
            $profile_image = "/Hopfenspeicher/uploads/$profile_image";
          } else {
            $profile_image = "/Hopfenspeicher/Assets/user_empty.png";
          }
          ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                <img src="<?php echo $profile_image; ?>" style="height:20px;"/>
                <?php echo $loggedin_user->getUsername(); ?>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="/Hopfenspeicher/User/profile.php?User=<?php echo $loggedin_user->getUsername(); ?>">Mein Profil</a>
                <a class="dropdown-item" href="/Hopfenspeicher/User/inc/logout_inc.php?logout=true">Abmelden</a>
              </div>
            </li>
          <?php
        } else {
          ?>
          <li class="nav-item">
            <a class="nav-link" href="/Hopfenspeicher/User/login.php">Anmelden</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Hopfenspeicher/User/signup.php">Registbieren</a>
          </li>
          <?php
        }
      ?>
      </ul>
    </div>
  </nav>

  <!-- container -->
  <div class="container">
    <br>
      <?php
      // show page header
      if ($showPageTitle) {
        echo "<div class='page-header'><h1>{$page_title}</h1></div>";
      }
      ?>
