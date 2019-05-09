<?php
$page_title = $_GET['User'] . "'s Profil";

//You may  not be on this page when loggedout
$redirect_when_loggedin = false;
$redirect_when_loggedout = true;
$redirect_page = 'index.php';

include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/User/inc/profile_inc.php';

//waites for press of save Button and tries to execute saveChanges function
//Displays warning message when exception is thrown
if (isset($_POST['save']) ) {
  try {
    if(!empty($_FILES["image"]["name"])){
      $image = sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]);
      $profileUser->setImage($image);
      echo uploadImage($image);
    }
    saveChanges($profileUser);
  } catch(Exception $e) { ?>
    <div class="alert alert-warning alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Warning!</strong> <?php echo $e->getMessage(); ?>
    </div>
  <?php
  }
}
if (isset($_POST['deleteProfileImage']) ) {
  try {
    deleteImage($profileUser);
  } catch(Exception $e) { ?>
    <div class="alert alert-warning alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Warning!</strong> <?php echo $e->getMessage(); ?>
    </div>
  <?php
  }
}
if (isset($_POST['deleteReview'])) {
  try {
    deleteReview($db, $_POST['beer_id'], $_POST['user_id']);
  } catch(Exception $e) { ?>
    <div class="alert alert-warning alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Warning!</strong> <?php echo $e->getMessage(); ?>
    </div>
  <?php
  }
}
?>
<br/>
  <!--Table that displays all information about the User-->
  <?php
  //Profile Page when the site is in view mode
  if ($edit == false) {
  ?>
  <div class="row">
    <div class="col-8">
      <h1><?php echo $username ?>'s Benutzerprofil</h1>
    </div>
    <div class="col">
      <?php
      //The Button that activates edit mode for the profile.
      //This button only shows when the profile belongs to the user that's logged in.
      if ($ownProfile == true) {
      ?>
        <form action="" method="POST">
          <input type="submit" name="edit" class="btn btn-primary" value="Profil Bierarbeiten">
        </form>
      <?php
      }
      ?>
    </div>
  </div>
  <br/>
  <div class="row">
    <!--The Profile picture of the user-->
    <div class="col-4">
      <img src="<?php echo $image; ?>" alt="Profilbild" class="img-fluid"/>
    </div>
    <!--Personal Information about the user-->
    <div class="col-4">
      <h3 align="left" hspace="500">Biernutzername</h3>
      <?php echo $username ?>
      <h3 align="left" hspace="500">Vorname</h3>
      <?php echo $firstname ?>
      <h3 align="left" hspace="500">Nachname</h3>
      <?php echo $lastname ?>
      <h3 align="left" hspace="500">E-Mail</h3>
      <?php echo $email ?>
      <h3 align="left" hspace="500">Lieblingsbier</h3>
      <?php
      if (!is_null($favBeer_name)) {
        ?>
        <a href="<?php echo "../beer/beer_details.php?name=".urlencode($favBeer_name); ?>"><?php echo $favBeer_name; ?></a>
        <?php
      } else {
        echo '<i>Kein Bier angegeben.</i>';
      }
      ?>
      <h3 align="left" hspace="500">Über mich</h3>
      <?php echo $description ?>
    </div>
  </div>
  <?php
  //Profile Page when the site is in edit mode
  } else {
  ?>
  <form class="userInformation" action="" method="POST" enctype="multipart/form-data">
  <div class="row">
    <div class="col-8">
      <h1><?php echo $username ?>'s Benutzerprofil</h1>
    </div>
    <div class="col-4">
      <input type="submit" name="save" class="btn btn-primary" value="Bierarbeitungen übernehmen">
    </div>
  </div>
  <br/>
    <div class="row">
      <div class="col-4">
        <div class="row">
          <div class="col">
            <img src="<?php echo $image; ?>" class="img-fluid"/>
          </div>
        </div>
        <div class="row py-1">
          <div class="col-8">
            <div class="row">
              <label for="image">Profilbild ändern:</label>
            </div>
            <div class="row">
              <input type="file" name="image" class="form-control-file" accept=".png,.jpg,.jpeg,.gif"/>
            </div>
          </div>
          <div class="col-4">
            <input type="submit" name="deleteProfileImage" class="btn btn-danger align-right" value="Löschen">
          </div>
        </div>
      </div>
      <div class="col-7">
        <h3 align="left" hspace="500">Biernutzername</h3>
        <input type="text" name="username" class="form-control" size="25" value="<?php echo $username ?>"/>
        <h3 align="left" hspace="500">Vorname</h3>
        <input type="text" name="firstname" class="form-control" size="25" value="<?php echo $firstname ?>"/>
        <h3 align="left" hspace="500">Nachname</h3>
        <input type="text" name="lastname" class="form-control" size="25" value="<?php echo $lastname ?>"/>
        <h3 align="left" hspace="500">E-Mail</h3>
        <input type="text" name="email" class="form-control" size="25" value="<?php echo $email ?>"/>
        <h3 align="left" hspace="500">Über mich</h3>
        <textarea type="text" name="description" class="form-control" size="25"><?php echo $description ?></textarea>
      </div>
    </div>
  </form>
  <?php
  }
  //End of the table
  ?>
<br/>
<?php
//get Array of review objects
$review_array = Review::readAll(null, $profileUser->getId(), $db);
if(sizeof($review_array)>0){?>
  <div class="row">
    <h2>Abgegebene Bierwertungen</h2>
  </div>
<?php
}
foreach ($review_array as $review) {
  $beer = new Beer($db);
  $beer->setId($review->getBeer_id());
  $beer->readOne();
  $image = $beer->getFullImagePath();
?>
  <br/>
  <form method="post">
    <input type="hidden" name="beer_id" value="<?php echo $review->getBeer_id();?>">
    <input type="hidden" name="user_id" value="<?php echo $review->getUser_id();?>">
    <div class="row">
      <div class="col-12">
        <div class="media border p-3">
          <img src='<?php echo $image; ?>' alt="Profilbild" class="mr-3 rounded-circle" height="80px" width="80px";>
          <div class="media-body">
            <h4><a href="/Hopfenspeicher/Beer/beer_details.php?name=<?php echo $beer->getName(); ?>"><?php echo $beer->getName(); ?></a>
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
