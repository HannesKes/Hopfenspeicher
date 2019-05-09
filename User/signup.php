<?php
  $page_title = "Registbieren";

  //You may not be on this page when you are logged in.
  //Redirect to profile page
  $redirect_when_loggedin = true;
  $redirect_when_loggedout = false;
  $redirect_page = 'profile.php';

  include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';?>

  <br/>
  <h3>Registbieren</h3><br/>
  Herzlich willkommen im Hopfenspeicher! Es ist schön, dich bald zu uns zählen zu dürfen!
  <form action="inc/signup_inc.php" class="needs-validation" method="post" novalidate>
    <div class="form-group">
      <label for="uname">Vorname:</label>
      <input type="text" class="form-control" id="firstname" placeholder="Vorname" name="firstname" required>
      <div class="valid-feedback">Korrekt.</div>
      <div class="invalid-feedback">Bitte fülle dieses Feld aus.</div>
    </div>
    <div class="form-group">
      <label for="uname">Nachname:</label>
      <input type="text" class="form-control" id="lastname" placeholder="Nachname" name="lastname" required>
      <div class="valid-feedback">Korrekt.</div>
      <div class="invalid-feedback">Bitte fülle dieses Feld aus.</div>
    </div>
    <div class="form-group">
      <label for="uname">Biernutzername:</label>
      <input type="text" class="form-control" id="uname" placeholder="Biernutzername" name="username" required>
      <div class="valid-feedback">Korrekt.</div>
      <div class="invalid-feedback">Bitte fülle dieses Feld aus.</div>
    </div>
    <div class="form-group">
      <label for="uname">E-Mail:</label>
      <input type="email" class="form-control" id="email" placeholder="E-Mail" name="email" required>
      <div class="valid-feedback">Korrekt.</div>
      <div class="invalid-feedback">Das ist keine gültige E-Mail-Adresse.</div>
    </div>
    <div class="form-group">
      <label for="pwd">Passwort:</label>
      <input type="password" class="form-control" id="password" placeholder="Passwort" name="password" required>
      <div class="valid-feedback">Korrekt.</div>
      <div class="invalid-feedback">Bitte fülle dieses Feld aus.</div>
    </div>
    <div class="form-group form-check">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="remember" required> Ich stimme zu, meine Seele dem Bier zu widmen.
        <div class="valid-feedback">Korrekt.</div>
        <div class="invalid-feedback">Dieses Feld ist erforderlich.</div>
      </label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button><br/>
    Du hast schon einen Account? Jetzt <a href="login.php">anmelden</a>.
  </form>
  <br/>
  </div>
  <!--End of page content-->

  <!--footer-->
  <?php include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/footer.php';?>
