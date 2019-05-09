<?php
//You may always be on this page
$redirect_when_loggedin = false;
$redirect_when_loggedout = false;
$redirect_page = '../index.php';

$page_title = "Alle Benutzer";
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';

//get ID of logged in User if the User is logged in.
$loggedUser_ID = null;
if (isset($_SESSION['session_id'])) {
  $loggedUser_ID = $_SESSION['session_id'];
}

//Page that is given in the URL: Default value is one.
$page = isset($_GET['page']) ? $_GET['page'] : 1;

//Set ne number of records per page and the LIMIT clause for the get.
$records_per_page = 5;
$from_record_num = ($records_per_page * $page) - $records_per_page;

// instantiate database and objects
$database = new Database();
$db = $database->getConnection();

//get Array of user objects
$user_array = User::readAll($from_record_num, $records_per_page, $db);

foreach ($user_array as $user) {
  if(($user->getImage() != '') AND (file_exists('../uploads/' . $user->getImage()))){
    $image = '/Hopfenspeicher/uploads/' . $user->getImage();
  } else {
    $image = "/Hopfenspeicher/Assets/user_empty.png";
  }?>
  <div class="row">
    <div class="col-12">
      <div class="media border p-3">
        <img src='<?php echo $image; ?>' alt="Profilbild" class="mr-3 rounded-circle" height="80px" width="80px";>
        <div class="media-body">
          <h4><a href="/Hopfenspeicher/User/profile.php?User=<?php echo $user->getUsername(); ?>"><?php echo $user->getUsername(); ?></a>
            <?php if ($loggedUser_ID != $user->getId()) { ?>
              <span class="float-right">Freund hinzufügen kommt noch (maybe)<!--Add friend button--></h4>
            <?php } ?>
              <h5><b><?php echo $user->getFirstname() . " " . $user->getLastname(); ?></b></h5>
          <?php $description = $user->getDescription();
          if (empty($description)) {
            echo "<p><i>Keine Beschreibung vorhanden.</i></p>";
          } else {
            echo "<p>" . $description . "</p>";
          } ?>
          <small><i>Mitglied seit <?php echo $user->getTimestamp(); ?></i></small>
        </div>
      </div>
    </div>
  </div>
<?php }

// the page where this paging is used
$page_url = "index.php?";

// count all products in the database to calculate total pages
$total_rows = $user->countAll();

// paging buttons here
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/paging.php';

include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/footer.php';
?>
