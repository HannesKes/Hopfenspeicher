<!--
  session_start();
  $_SESSION['LastPage'] = $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];

  include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/db.php';
  include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Biere/inc/beerFunction_inc.php';
  $brewery = $_GET['Brauerei'];
  $Sorte = $_GET['Sorte'];

  $sql = "SELECT * FROM bier WHERE (Brauerei LIKE \"$brewery\") AND (Sorte LIKE \"$Sorte\");";
  $ergBier = $connection->query($sql) or die($connection->error);
  $datensatzBier = $ergBier->fetch_assoc();
  $resultCheck = mysqli_num_rows($ergBier);

  if ($resultCheck < 1) {
      header("Location: ../error.php?errorcode=2");
      exit();
  }

  $Bier_ID = $datensatzBier['ID'];

  $sql = "SELECT AVG(bewertung) as AVGBewertung FROM Bewertungen WHERE (Bier_ID=$Bier_ID)";
  $ergBewertung = $connection->query($sql) or die($connection->error);
  $erg = $ergBewertung->fetch_assoc();

  $AVGBewertung = ROUND($erg['AVGBewertung'],1);
  $name = $datensatzBier['Name'];
  $nameOhneLeer = str_replace(' ', '+', $name);
  $link = "https://www.getraenkewelt.de/?customer_class=0&multishop_id=0&ActionCall=WebActionArticleSearch&Params%5BSearchParam%5D=$nameOhneLeer";
  ?>


<!DOCTYPE html>
<html>
<head>
    <title>< echo $datensatzBier['Name']; ?>: Dein Bier im Detail</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Hopfenspeicher/Style/customStyle.css">
  </head>
  <body>
    <include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';?>


    <!-- Page Content-->
<!--    <div class="container">
      <br>
    <a href="< echo $_SERVER['HTTP_REFERER']; ?>"><button>Zurück</button></a>

-->

<?php
$brewery = isset($_GET['brewery']) ? $_GET['brewery'] : die('ERROR: missing brewery.');
$type = isset($_GET['type']) ? $_GET['type'] : die('ERROR: missing type.');

// include database and object files
include_once '../Extras/database.php';
include_once 'objects/beer.php';
include_once 'objects/type.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare objects
$beer = new Beer($db);
$type = new Type($db);

// set brewery, type properties of product to be read
$beer->brewery = $brewery;
$beer->type = $type;//TODO setter

// read the details of product to be read
$beer->readOne();

// set page headers
$page_title = "Bier Details";
include_once "../Extras/layout_header.php";
?>

<table class='table table-hover table-responsive table-bordered'>
  <tr>
    <td colspan="2"><h1><?php echo $datensatzBier['Name']; ?></h1></td>
  </tr>
  <tr>
    <td colspan="2"><h4>Durchschnittl. Bierwertung: <?php echo $AVGBewertung; ?>/10 (Symbol: Kronkorken)</h4></td>
  </tr>
  <tr>
    <td><!--<img src="../bild.php?BildNr=<php echo $datensatzBier['Bild_ID']; ?>" height="500" width="300" alt="Bild vom Bier" border="2" align="left" hspace="50" />--></td>
    <td>
      <h3 align="left" hspace="500">Brauerei</h3>
      <?php echo $beer->brewery; ?>
      <h3 align="left" hspace="500">Sorte</h3>
      <?php echo $beer->type_id; ?>
      <h3 align="left" hspace="500">Alkoholgehalt</h3>
      <?php echo 'folgt'; ?> % Vol.
      <h3 align="left" hspace="500">Bierschreibung</h3>
      <?php echo $beer->description; ?>
      <h3 align="left" hspace="500">Zutaten</h3>
      <?php echo 'folgt'; ?>
    </td>
  </tr>
</table>

<?php
// set footer
include_once "../Extras/layout_footer.php";
?>






    <?php
    if (isset($_SESSION['session_id'])) {
    ?>
      <form class="favBier" action="" method="POST">
        <input type="submit" name="makeFavourite" class="makeFavourite" value="Favorisieren">
      </form>
    <?php
      if (isset($_POST['makeFavourite']))
      $User_ID = $_SESSION['session_id'];
      $sql = "UPDATE users SET favbeer_id = '$Bier_ID' WHERE id = '$User_ID'";
      $result = mysqli_query($connection, $sql);
    }
    ?>

    <a href=<?php echo $link; ?> target="_blank", style="float:right"><button>Bier bestellen</button></a></p>


  <div class="Bewertungen">
    <h2 class="ratingHeading">Bierwertungen</h2>

    <?php
      $ergKommentare = $connection->query("SELECT * FROM bewertungen WHERE (Bier_ID=$Bier_ID)") or die($connection->error);
      $datensatzKommentare = $ergKommentare->fetch_all(MYSQLI_ASSOC);
      foreach($datensatzKommentare as $kommentar) {
        $User_ID = $kommentar['User_ID'];
        $sql = "SELECT username,Bild_ID FROM users WHERE (ID=$User_ID)";
        $ergUser = $connection->query($sql) or die($connection->error);
        $user = $ergUser->fetch_assoc();
    ?>
        <div class="Bewertung">
          <table class="ratingTable">
            <caption class="ratingCaption"><?php echo $kommentar['Titel']; ?><caption>
            <thead class="ratingTableHead">
              <tr>
                <td>
                  <a class="nav-link" href="/Hopfenspeicher/User/profile.php?User=<?php echo $user['username']; ?>">
                  <?php echo $user['username']; ?></a></td>
                <td><?php echo $kommentar['bewertung']; ?>/10 Kronkorken als Bewertung</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><img src="../bild.php?BildNr=<?php echo $user['Bild_ID']; ?>" height="70" width="80" alt="Profilbild" border="2" align="left" /></td>
                <td><?php echo $kommentar['Inhalt']; ?></td>
              </tr>
            </tbody>
            <tfoot class="ratingTableFoot">
              <td colspan="2">Erstellt am <?php echo $kommentar['Datum']; ?></td>
            </tfoot>
          </table>
        </div>
        <br/>
        <?php
        }
        ?>
    </div>
  </div>
