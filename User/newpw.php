<?php
$page_title = "Password zurücksetzen";

//You may not be on this page when you are logged in.
//Redirect to profile page
$redirect_when_loggedin = true;
$redirect_when_loggedout = false;
$redirect_page = 'profile.php';

include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';
?>
  <br/>
<?php include_once 'inc/newpw_inc.php '?>
<h1>Neues Password vergeben</h1>
<form action="?send=1&userid=<?php echo htmlentities($user->getId()); ?>&code=<?php echo htmlentities($code); ?>" method="post">
  Bitte gib ein neues Passwort ein:<br/>
  <input type="password" name="password"><br/><br/>
  Passwort erneut eingeben:<br/>
  <input type="password" name="password2"><br/><br/>
  <input type="submit" name="passwordReset" value="Passwort speichern">
</form>
<br/>
<?php include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/footer.php';?>
