<?php
$page_title = "Password vergessen";

//You may not be on this page when you are logged in.
//Redirect to profile page
$redirect_when_loggedin = true;
$redirect_when_loggedout = false;
$redirect_page = 'profile.php';

include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/User/inc/forgotpw_inc.php';
if($showForm){
?>
  <h1>Password vergessen</h1>
  Gib hier deine E-Mail-Adresse ein, um ein neues Password anzufordern.<br/><br/>
  <?php
  if(isset($error) && !empty($error)) {
   echo $error;
  }
  ?>
  <form action="?send=1" method="post">
    E-Mail:<br/>
    <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlentities($_POST['email']) : ''; ?>"><br/>
    <input type="submit" value="Neues Password">
  </form>
<?php
};
?>
<?php include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/footer.php';?>
