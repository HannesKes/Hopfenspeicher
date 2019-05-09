<?php
// include database and object files
include_once '../Extras/db.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/beer.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/brewery.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/type.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/beer_ingredient.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/ingredient.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/review.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/user.php';

// set page headers
$page_title = "Bier Details";

//You may always be on this page
$redirect_when_loggedin = false;
$redirect_when_loggedout = false;
$redirect_page = 'index.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare objects
$beer = new Beer($db);
$brewery = new Brewery($db);
$type = new Type($db);

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $beer->setId($id);
}elseif (isset($_GET['name'])){
  //urldecode funktionier anders als gedacht.
  // TODO: Genaue Funktionsweise herausfinden.
  //$name = urldecode($_GET['name']);
  $beer->setName($_GET['name']);
} else {
  header("Location: $redirect_page");
}
// read the details of beer to be read
if(!$beer->readOne()){
  echo $beer->getName();
  //if you dont find one you get redirected
  header("Location: $redirect_page");
}

//Gets the avg rating
$avg_rating = number_format(Review::getAVGRating($db,$beer->getId()),1);
$rating_text = ($avg_rating == 0) ? 'Noch keine Bierwertungen vorhanden.' : $avg_rating.'/10 Kronkorken';

if(($beer->getImage() != '') AND (file_exists('../uploads/' . $beer->getImage()))){
  $image = '/Hopfenspeicher/uploads/' . $beer->getImage();
} else {
  $image = "/Hopfenspeicher/Assets/beer_empty.png";
}

//link to the shop
$beer_without_blanks = str_replace(' ', '+', $beer->getName());
$link = "https://www.getraenkewelt.de/?customer_class=0&multishop_id=0&ActionCall=WebActionArticleSearch&Params%5BSearchParam%5D=$beer_without_blanks";

include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';

//POST Actions
if (isset($_POST['makeFav']) ) {
  $beer_id = $beer->getId();
  $loggedin_user->setFavBeer_ID($beer_id);
  $loggedin_user->update();
}
if (isset($_POST['deleteFav']) ) {
  $loggedin_user->setFavBeer_ID(null);
  $loggedin_user->update();
}
if (isset($_POST['deleteReview'])) {
  $review->setBeer_id($beer->getId());
  $review->setUser_id($loggedin_user->getId());
  $review->delete();
  $beer_name = $beer->getName();
  header("location: beer_details.php?name=$beer_name");
}
// All ingredients as string
$beer_ingredient_array = Beer_Ingredient::readAll($beer->getId(), null, $db);
$ingredients_string = "";
foreach ($beer_ingredient_array as $beer_ingredient) {
  $ingredient = new Ingredient($db);
  $ingredient->setId($beer_ingredient->getIngredient_id());
  $ingredient->readOne();
  $ingredients_string.=$ingredient->getName().", ";
}
$ingredients_string = substr($ingredients_string, 0, strlen($ingredients_string)-2);
?>

<div class="row">
  <div class="col-8">
    <h1><?php echo $beer->getName() ?></h1>
  </div>
  <?php
  if ($loggedin == true) {
    $loggedin_user->readOne();
    $isFavBeer = ($loggedin_user->getFavbeer_id() == $beer->getId()) ? true : false; //Beer is already favbeer
    $beerIsRated = false; // Beer is already rated
    //$beerIsRated aus DB ziehen. So kann kein Fehler entstehen, wenn Bierwertung gelöscht wurde
  ?><div class="col-4 text-right">
      <a href=<?php echo $link; ?> target="_blank", style="float:right"><button type="button" class="btn btn-primary mx-1">Bier bestellen</button></a>
      <form action="" method="POST">
        <!-- check if beer is already favBeer and choose correct button-->
        <?php if($isFavBeer){?>
          <input type="submit" name="deleteFav" class="btn btn-secondary mb-1 col-20" value="Entfavoribieren">
          <?php
        } else {?>
          <input type="submit" name="makeFav" class="btn btn-success mb-1 col-20" value="Favoribieren">
          <?php
        }?>
        <!-- check if beer is already rated and choose correct button -->
        <?php if($beerIsRated){
          $name_button = "Bierwertung bearbeiten";
        } else {
          $name_button = "Bierwerten";
        } ?>
        <input formaction="create_review.php?beer_id=<?php echo $beer->getId() ?>" type="submit" class="btn btn-warning mb-1 col-20" value="<?php echo $name_button; ?>">
      </form>
    </div>
  <?php
  }?>
</div>
<div class="row">
  <div class="col">
    <h5>Durchschnittliche Bierwertung: <?php echo $rating_text; ?></h5>
  </div>
</div>
<div class="row">
  <div class="col-4">
    <img src="<?php echo $image ?>" class="img-thumbnail">
  </div>
  <div class="col-8">
    <h3>Brauerei</h3>
    <?php
      $brewery->setId($beer->getBrewery());
      $brewery->readName();
      echo $brewery->getName();
    ?>
    <h3>Sorte</h3>
    <?php
      $type->setId($beer->getType_id());
      $type->readName();
      echo $type->getName();
    ?>
    <h3>Alkoholgehalt</h3>
    <?php echo $beer->getAlcstrength(); ?> % Vol.
    <h3>Bierschreibung</h3>
    <?php echo $beer->getDescription(); ?>
    <h3>Zutaten</h3>
    <?php
      echo $ingredients_string;
    ?>
  </div>
</div>
<?php
//get Array of review objects
$review_array = Review::readAll($beer->getId(), null, $db);
if(sizeof($review_array)>0){?>
  <div class="row">
    <h2>Bierwertungen</h2>
  </div>
<?php
}
foreach ($review_array as $review) {

  $user = new User($db);
  $user->setId($review->getUser_id());
  $user->readOne();

  if(($user->getImage() != '') AND (file_exists('../uploads/' . $user->getImage()))){
    $image = '/Hopfenspeicher/uploads/' . $user->getImage();
  } else {
    $image = "/Hopfenspeicher/Assets/user_empty.png";
  }?>
  <br/>
  <form method="post">
  <div class="row">
    <div class="col-12">
      <div class="media border p-3">
        <img src='<?php echo $image; ?>' alt="Profilbild" class="mr-3 rounded-circle" height="80px" width="80px";>
        <div class="media-body">
          <h4><a href="/Hopfenspeicher/User/profile.php?User=<?php echo $user->getUsername(); ?>"><?php echo $user->getUsername(); ?></a>
          <span class="float-right"><?php echo $review->getRating(); ?>/10 Kronkorken</span></h4>
          <h5><b><?php echo $review->getTitle(); ?></b></h5>
          <p><?php echo $review->getContent(); ?></p>
          <small><i>Erstellt am <?php echo $review->getTimestamp(); ?></i></small>
          <?php
          if ($loggedin == true) {
            $loggedin_user->readOne();
            if($loggedin_user->getId() == $review->getUser_id()){?>
              <span class="float-right"><input type="submit" name="deleteReview" class="btn btn-danger mb-1 col-20 btn-sm" value="Löschen"></span>
            <?php
            }
          }?>
        </div>
      </div>
    </div>
  </div>
  </form>
 <?php
}?>



<?php include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/footer.php';?>
