<?php
$page_title = "Anmelden";

//You may not be on this page when you are logged in.
//Redirect to profile page
$redirect_when_loggedin = true;
$redirect_when_loggedout = false;
$redirect_page = 'profile.php';

include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';
?>
Bitte melde dich mit deinen Zugangsdaten an.<br/>
<form action="inc/login_inc.php" class="needs-validation" method="post" novalidate>
  <div class="form-group">
    <label for="username">Biernutzer:</label><br/>
    <input type="text" class="form-control" id="username" placeholder="Biernutzername" name="username" required>
  </div>
  <div class="form-group">
    <label for="password">Passwort:</label><br/>
    <input type="password" class="form-control" id="password" placeholder="Passwort" name="password" required>
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Anmelden</button><br/>
</form><br/>
<a href ="forgotpw.php">Passwort vergessen?</a><br/>
Stattdessen <a href ="signup.php">registbieren?</a><br/><br/>
<?php include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/footer.php';?>
