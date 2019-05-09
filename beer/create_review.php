<?php
// include database and object files
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/review.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/beer.php';

// set page header
$page_title = "Bierwerten";

//You may not be on this page when logged out
$redirect_when_loggedin = false;
$redirect_when_loggedout = true;
$redirect_page = 'index.php';

include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';

// instantiate database and objects
$database = new Database();
$db = $database->getConnection();

$review = new Review($db);
$beer = new beer($db);

$user_id = $_SESSION['session_id'];
$beer_id = $_GET['beer_id'];

// query products
$review->setUser_id($user_id);
$review->setBeer_id($beer_id);
$review->readOne();

$beer->setId($beer_id);
$beer->readOne();

$rating = $review->getRating();

//POST Actions
if (isset($_POST['reviewCancel'])) {
  header("location: beer_details.php?id=$beer_id");
}
if (isset($_POST['reviewSubmit'])) {
  $review->setTitle($_POST['reviewTitle']);
  $review->setContent($_POST['reviewContent']);
  $review->setRating($_POST['reviewRating']);
  if ($review->getId()!=0) {
    $review->update();
  } else {
    $review->create();
  }
  header("location: beer_details.php?id=$beer_id");
}
?>

<h1><?php echo $beer->getName(); ?> bierwerten</h1>

<form method="post">
  <div class="form-group">
    <label for="reviewTitle">Titel</label>
    <input type="text" class="form-control" name="reviewTitle" value="<?php echo $review->getTitle(); ?>">
  </div>
  <div class="form-group">
    <label for="reviewRating">Wie viele Kronkorken möchtest du diesem Bier geben?</label>
    <select class="form-control" name="reviewRating" value="7">
      <option <?php if($rating == '1'){echo("selected");}?>>1 Kronkorken</option>
      <option <?php if($rating == '2'){echo("selected");}?>>2 Kronkorken</option>
      <option <?php if($rating == '3'){echo("selected");}?>>3 Kronkorken</option>
      <option <?php if($rating == '4'){echo("selected");}?>>4 Kronkorken</option>
      <option <?php if($rating == '5'){echo("selected");}?>>5 Kronkorken</option>
      <option <?php if($rating == '6'){echo("selected");}?>>6 Kronkorken</option>
      <option <?php if($rating == '7'){echo("selected");}?>>7 Kronkorken</option>
      <option <?php if($rating == '8'){echo("selected");}?>>8 Kronkorken</option>
      <option <?php if($rating == '9'){echo("selected");}?>>9 Kronkorken</option>
      <option <?php if($rating == '10'){echo("selected");}?>>10 Kronkorken</option>
    </select>
  </div>
  <div class="form-group">
    <label for="reviewComment">Kommentar</label>
    <textarea class="form-control" name="reviewContent" rows="3"><?php echo $review->getContent(); ?></textarea>
  </div>
  <div class="form-group float-right">
    <input type="submit" name="reviewCancel" class="btn btn-secondary" value="Abbrechen">
    <input type="submit" name="reviewSubmit" class="btn btn-primary" value="Senden">
  </div>
</form>
<?php include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/footer.php';?>
