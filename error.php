<?php
$page_title = "Fehler";

//You may always be on this page
$redirect_when_loggedin = false;
$redirect_when_loggedout = false;
$redirect_page = 'index.php';

include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';
?>
<br>
<h3><?php echo "Fehlercode $ErrorCode: $Name";?></h3>
<?php echo $Inhalt; ?>
<br/><br/><a href="<?php echo $_SESSION['LastPage'] ?>">Gehe jetzt zurück zu deiner vorherigen Seite.<br/>
<br/><br/>
<?php include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/footer.php';?>
