<?php
$page_title = "Hopfenspeicher";

//You may always be on this page
$redirect_when_loggedin = false;
$redirect_when_loggedout = false;
$redirect_page = 'index.php';

include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/beer.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/type.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/brewery.php';

// Bilder vorerst fest eingebunden. Später gibts sowas nicht mehr.
$imageHeadCarousel = "/Hopfenspeicher/Assets/Bier7.jpg";

$database = new Database();
$db = $database->getConnection();
$beer = new Beer($db);
$brewery = new Brewery($db);
$type = new Type($db);
?>

<!-- Erstes Einstiegs-Carousel -->
<div id="indexCarousel" class="carousel slide carousel-fade carousel-multi-item" data-ride="carousel" data-interval="7000">
  <ol class="carousel-indicators">
    <!-- the indicators are the little dots at the bottom of each slide.
          They indicate how many slides there are in the carousel, and which slide the user is currently viewing -->
    <li data-target="#indexCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#indexCarousel" data-slide-to="1"></li>
    <li data-target="#indexCarousel" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox">

    <!-- the active class indicates the first slide and makes the carousel visible -->
    <div class="carousel-item active">
      <div class="row">
        <div class="col-sm" style="width: 50rem;">
          <img class="d-block w-100" src="<?php echo $imageHeadCarousel ?>" alt="1 slide">
          <div class="carousel-caption text-light d-md-block">
            <h1>Der Hopfenspeicher</h1>
            <h4>Auch Wasser wird zum edlen Tropfen, mischt man es mit Malz und Hopfen.</h4>
          </div>
        </div>
      </div>
    </div>

    <div class="carousel-item">
      <div class="row">
        <div class="col-sm">
          <img class="d-block w-100" src="<?php echo $imageHeadCarousel ?>" alt="1 slide">
          <div class="carousel-caption text-light d-md-block">
            <h1>Bewertungssystem</h1>
            <h4>Teile Anderen mit, wie gut das Bier schmeckt.</h4>
          </div>
        </div>
      </div>
    </div>

    <div class="carousel-item">
      <div class="row">
        <div class="col-sm">
          <img class="d-block w-100" src="<?php echo $imageHeadCarousel ?>" alt="1 slide">
          <div class="carousel-caption text-light d-md-block">
            <h1>More is coming soon...</h1>
            <h4>Work in progress...</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#indexCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#indexCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<!--End of carousel-->

<br>
<!--Carousel with selection of beers from the database-->
<h1 align="center">Unsere Biere</h1>

<!-- Bier-Carousel -->
<div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel" data-interval="7000">

  <!--Indicators-->
  <ol class="carousel-indicators">
    <li data-target="#multi-item-example" data-slide-to="0" class="active"></li>
    <li data-target="#multi-item-example" data-slide-to="1"></li>
    <li data-target="#multi-item-example" data-slide-to="2"></li>
  </ol>
  <!--/.Indicators-->

  <!--Slides-->
  <div class="carousel-inner" role="listbox">
    <!--The carousel item thats active when the page is loaded-->
    <div class="carousel-item active">
    <div class="row">
    <?php
    $stmt = $beer->readAll(1, 3);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      extract($row,EXTR_PREFIX_ALL,'beer');
      $type->setId($beer_type_id);
      $type->readOne();
      $brewery->setId($beer_brewery_id);
      $brewery->readOne();
      $image = $beer_image;
      if(($image != '') AND (file_exists('uploads/' . $image))){
        $image = 'uploads/' . $beer_image;
      } else {
        $image = "Assets/beer_empty.png";
      }
    ?>
        <div class="col-md-4">
          <div class="card text-center text-white bg-dark border-dark mb-3" style="max-width: 25rem;">
            <img class="card-img-top mb-2" src="<?php echo $image; ?>" alt="cardImage" style="height: 20rem;">
            <div class="card-body" style="min-height: 17rem;">
              <h4 class="card-title"><?php echo $beer_name; ?></h4>
              <p class="card-text" align="center" style="bottom: 0px;">
                <?php echo $brewery->getName(); ?><br/>
                <?php echo $type->getName(); ?><br/>
                <?php echo $beer_alcstrength; ?>% Vol.
              </p>
              <div align="center" style="position: absolute; width:100%; bottom:30px; left:0; right:0;">
                <a class="btn btn-light" href="<?php echo "beer/beer_details.php?name=".urlencode($beer_name);?>">Zum Bier</a>
              </div>
            </div>
          </div>
        </div>
      <?php
    }
    ?>
    </div>
    </div>

    <?php
    $from_record_num = 4;
    for ($i=0; $i<2;$i++) {

      ?>
      <div class="carousel-item">
      <div class="row">
      <?php
      $stmt = $beer->readAll($from_record_num, 3);

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row,EXTR_PREFIX_ALL,'beer');
        $type->setId($beer_type_id);
        $type->readOne();
        $brewery->setId($beer_brewery_id);
        $brewery->readOne();
        $image = $beer_image;
        if(($image != '') AND (file_exists('uploads/' . $image))){
          $image = 'uploads/' . $beer_image;
        } else {
          $image = "Assets/beer_empty.png";
        }
      ?>
      <!--First slide-->
          <div class="col-md-4">
            <div class="card text-center text-white bg-dark border-dark mb-3" style="max-width: 25rem;">
              <img class="card-img-top mb-2" src="<?php echo $image; ?>" alt="cardImage" style="height: 20rem;">
              <div class="card-body" style="min-height: 17rem;">
                <h4 class="card-title"><?php echo $beer_name; ?></h4>
                <p class="card-text">
                  <?php echo $brewery->getName(); ?><br/>
                  <?php echo $type->getName(); ?><br/>
                  <?php echo $beer_alcstrength; ?>% Vol.
                </p>
                <div align="center" style="position: absolute; width:100%; bottom:30px; left:0; right:0;">
                  <a class="btn btn-light" href="<?php echo "beer/beer_details.php?name=".urlencode($beer_name);?>">Zum Bier</a>
                </div>
              </div>
            </div>
          </div>
        <?php
      }
      ?></div></div><?php
      $from_record_num = 7;
    }
    ?>

  </div>
  <!--/.Slides-->

  <!-- Navigation -->
  <a class="carousel-control-prev" href="#multi-item-example" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#multi-item-example" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>

</div>
<!--/.Bier-Carousel-->

<br>
<h1 align="center">More is coming soon...</h1>
<br/>

<?php include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/footer.php';?>
