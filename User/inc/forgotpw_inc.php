<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/db.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/user.php';

// instantiate database and objects
$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$showForm = true;

if(isset($_GET['send']) ) {
  if(!isset($_POST['email']) || empty($_POST['email'])) {
    $error = "<b>Bitte eine E-Mail-Adresse eintragen</b>";
  } else {
    $email = $_POST['email'];

    $user->setEmail($email);
    $user->readOne();

    if($user->getId()==FALSE) {
      $error = "<b>Kein Benutzer zu dieser email gefunden</b>";
    } else {
      //Überprüfe, ob der User schon einen Passwordcode hat oder ob dieser abgelaufen ist
      $passwordcode = generate_random_string();
      $userid =  $user->getId();

      $user->setPasswordcode($passwordcode);

      $user->update();

      $empfaenger = $user->getEmail();
      $betreff = "Neues Password für deinen Account auf dem Hopfenspeicher"; //Ersetzt hier den Domain-Namen
      $from = "From: Bier Bierensen <Bier@Bier.Bier>"; //Ersetzt hier euren Name und E-Mail-Adresse
      $url_passwordcode = 'http://localhost/Hopfenspeicher/User/newpw.php?userid='.$user->getId().'&code='.$passwordcode; //Setzt hier eure richtige Domain ein
      $text = 'Hallo '.$user->getUsername().',<br>
      für deinen Account auf dem Hopfenspeicher wurde nach einem neuen Password gefragt.
      Um ein neues Password zu vergeben, rufe innerhalb der nächsten 24 Stunden die folgende Website auf: <br>
      <a href="'.$url_passwordcode.'">'.$url_passwordcode.'</a>

      Sollte dir dein Password wieder eingefallen sein oder hast du dies nicht angefordert, so bitte ignoriere diese E-Mail.

      Viele Grüße,
      dein Bier';

      $page_title = "Passwort zurücksetzen";
      include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';
      ?>
      <h1><?php echo $betreff ?></h1>
      <?php echo $text;

      include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/footer.php';

      $showForm = false;
    }
  }
}

function generate_random_string() {
 if(function_exists('random_bytes')) {
   $bytes = random_bytes(16);
   $str = bin2hex($bytes);
 }
 return $str;
}
?>
