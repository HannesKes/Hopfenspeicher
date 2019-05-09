<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/db.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/user.php';

// instantiate database and objects
$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if(!isset($_GET['userid']) || !isset($_GET['code'])) {
 die("Leider wurde beim Aufruf dieser Website kein Code zum Zurücksetzen deines Passwords übermittelt");
}
$code = $_GET['code'];

$user->setId($_GET['userid']);



//Überprüfe dass ein Nutzer gefunden wurde und dieser auch ein Passwordcode hat
if(!$user->readOne() || $user->getPasswordcode() == null) {
 die("Es wurde kein passender Benutzer gefunden");
}

//Überprüfe den Passwordcode
if(($code) != $user->getPasswordcode()) {
 die("Der übergebene Code war ungültig. Stell sicher, dass du den genauen Link in der URL aufgerufen hast.");
}

//Der Code war korrekt, der Nutzer darf ein neues Password eingeben

if(isset($_POST['passwordReset'])) {
 $password = $_POST['password'];
 $password2 = $_POST['password2'];

 if($password != $password2) {
   echo "Bitte identische Passwörter eingeben";
 } else { //Speichere neues Password und lösche den Code
   $password = password_hash($password,PASSWORD_DEFAULT);

   $user->setpassword($password);
   $user->setPasswordcode(NULL);


   if($user->update()) {
     die("Dein Password wurde erfolgreich geändert");
     }
   }
}

?>
