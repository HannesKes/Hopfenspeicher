<?php
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 10;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

// include database and object files
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/db.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/beer.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/brewery.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/type.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/review.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/ingredient.php';

// instantiate database and objects
$database = new Database();
$db = $database->getConnection();

$beer = new Beer($db);
$type = new Type($db);
$brewery = new Brewery($db);
$ingredient = new Ingredient($db);

// set page header
$page_title = "Bierübersicht";

//You may always be on this page
$redirect_when_loggedin = false;
$redirect_when_loggedout = false;
$redirect_page = 'index.php';

include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';

// saving of the sorting order for the database query
if (isset($_POST['sortType'])){
  $sort = $_POST['sortType'];
  $_SESSION['sort'] = $sort;
} else if (isset($_SESSION['sort'])){
  $sort = $_SESSION['sort'];
} else {
  $sort = "bezAsc";
}

// saving of the filter for the brewery for the database query
if (isset($_POST['brewery_id'])){
  $filterBrew = $_POST['brewery_id'];
  $_SESSION['filterBrew'] = $filterBrew;
} else if (isset($_SESSION['filterBrew'])){
  $filterBrew = $_SESSION['filterBrew'];
} else {
  $filterBrew = "0";
}

// saving of the filter for the type for the database query
if (isset($_POST['type_id'])){
  $filterType = $_POST['type_id'];
  $_SESSION['filterType'] = $filterType;
} else if (isset($_SESSION['filterType'])){
  $filterType = $_SESSION['filterType'];
} else {
  $filterType = "0";
}

// saving of the filter for the minimum alcstrength for the database query
if (isset($_POST['alcLow'])){
  $filterAlcLow = $_POST['alcLow'];
  $_SESSION['filterAlcLow'] = $filterAlcLow;
} else if (isset($_SESSION['filterAlcLow'])){
  $filterAlcLow = $_SESSION['filterAlcLow'];
} else {
  $filterAlcLow = "0";
}

// saving of the filter for the maximum alcstrength for the database query
if (isset($_POST['alcHigh'])){
  $filterAlcHigh = $_POST['alcHigh'];
  $_SESSION['filterAlcLow'] = $filterAlcHigh;
} else if (isset($_SESSION['filterAlcHigh'])){
  $filterAlcHigh = $_SESSION['filterAlcHigh'];
} else {
  $filterAlcHigh = "100";
}

//saving filters in array
$filter = array();
if($filterBrew!="0"){
  $filter['filterBrew'] = $filterBrew;
}
if($filterType!="0"){
  $filter['filterType'] = $filterType;
}
if($filterAlcLow!="0"){
  $filter['filterAlcLow'] = $filterAlcLow;
}
if($filterAlcHigh!="100"){
  $filter['filterAlcHigh'] = $filterAlcHigh;
}


// echo "POST: <br/>";
// foreach ($_POST as $key => $value) {
//   echo $key . " = " . $value . "<br/>";
// }
//
// echo "GET: <br/>";
// foreach ($_GET as $key => $value) {
//   echo $key . " = " . $value . "<br/>";
// }


// query products
$stmt = $beer->readAll($from_record_num, $records_per_page, $sort, $filter);
$num = $stmt->rowCount();
?>

<h2 align="center">Übersicht aller Biere</h2>
<div class="row justify-content-center">
  <b class="pr-2">Sortierung: </b>
  <form name="sort" method="POST">
    <select name="sortType" class="form-control form-control-sm" onChange="sort.submit()">
    <option value="bezAsc" <?php if ($sort=="bezAsc"){echo "selected";} ?>>Bezeichnung aufsteigend</option>
    <option value="bezDesc" <?php if ($sort=="bezDesc"){echo "selected";} ?>>Bezeichnung absteigend</option>
    <option value="alkAsc" <?php if ($sort=="alkAsc"){echo "selected";} ?>>Alkoholgehalt aufsteigend</option>
    <option value="alkDesc" <?php if ($sort=="alkDesc"){echo "selected";} ?>>Alkoholgehalt absteigend</option>
    <!--<option value="bewAsc">Bewertung aufsteigend</option>
    <option value="bewDesc">Bewertung absteigend</option>
    <option value="anzBewDesc">Anzahl Bewertungen absteigend</option>-->
    </select>
   </form>
</div>
<br/>
<div class="row"> <!-- container for whole content -->

  <div class="col-3">

    <div class="card">
      <!-- first area for the brewery -->
      <article class="card-group-item">
        <header class="card-header">
          <h6 class="title">Brauerei </h6>
        </header>
        <div class="filter-content">
          <div class="card-body">

            <form name="brew" method="POST">
              <?php
              //request of selected brewery
              if (isset($filterBrew) and $filterBrew != "0"){
                $brewery->setId($filterBrew);
                $brewery->readName();
                $BrewFilterName=$brewery->getName();
              } else {
                $BrewFilterName="Alle";
              }
              // read the brewerys from the database
              $stmtBrew = $brewery->readAll();

              // put them in a select drop-down
              ?>
              <select class='form-control' name='brewery_id' onChange="brew.submit()">
                <option><?php echo $BrewFilterName; ?></option>
                <?php

                while ($row_brew = $stmtBrew->fetch(PDO::FETCH_ASSOC)){
                  extract($row_brew);
                  if ($name!=$BrewFilterName){
                    echo "<option value='{$id}'>{$name}</option>";
                  }
                }
                if($BrewFilterName!="Alle"){
                  echo "<option value='0'>Alle</option>";
                }
                ?>
              </select>
            </form>

          </div> <!-- card-body.// -->
        </div>
      </article> <!-- card-group-item.// -->

      <!-- second area for the type -->
      <article class="card-group-item">
        <header class="card-header">
          <h6 class="title">Sorte </h6>
        </header>
        <div class="filter-content">
          <div class="card-body">

            <form name="formType" method="POST">
            <?php
            //Abfrage der ausgewählten Brauerei
            if (isset($filterType) and $filterType != "0"){
              $type->setId($filterType);
              $type->readName();
              $TypeFilterName=$type->getName();
            } else {
              $TypeFilterName="Alle";
            }
            // read the product categories from the database
            $stmtType = $type->readAll();

            // put them in a select drop-down
            ?>
            <select class='form-control' name='type_id' onChange="formType.submit()">
              <option><?php echo $TypeFilterName; ?></option>
              <?php

              while ($row_Type = $stmtType->fetch(PDO::FETCH_ASSOC)){
                extract($row_Type);
                if ($name!=$TypeFilterName){
                  echo "<option value='{$id}'>{$name}</option>";
                }
              }
              if($TypeFilterName!="Alle"){
                echo "<option value='0'>Alle</option>";
              }
              ?>
              </select>
            </form>

          </div> <!-- card-body.// -->
        </div>
      </article> <!-- card-group-item.// -->

      <!-- first area for the brewery -->
      <article class="card-group-item">
      	<header class="card-header">
      		<h6 class="title">Zutaten </h6>
      	</header>
      	<div class="filter-content">
      		<div class="card-body">

            <?php
            // read the product categories from the database
            $stmtIngr = $ingredient->readAll();

            // put them in a select drop-down
            ?>
            <div align='left'>

            <?php
            while ($row_ingr = $stmtIngr->fetch(PDO::FETCH_ASSOC)){
              extract($row_ingr);
              echo "<div class='custom-control custom-checkbox'>";
              echo "<input type='checkbox' class='custom-control-input' id='{$id}'>";
              echo "<label class='custom-control-label' for='{$id}'>{$name}</label>";
              echo "</div>";
            }
            ?>

      		</div> <!-- card-body.// -->
      	</div>
      </article> <!-- card-group-item.// -->

      <!-- third area for the alcoholstrength -->
      <article class="card-group-item">
      	<header class="card-header">
      		<h6 class="title">Alkoholgehalt </h6>
      	</header>
      	<div class="filter-content">
      		<div class="card-body">
            <form name="alc" method="GET">
        		<div class="form-row">
              <!--<form name="alcLow" method="POST">-->
            		<div class="form-group col-md-6">
            		  <label>Min</label>
            		  <input type="number" class="form-control" step="0.01" onchange="alc.submit()" placeholder="<?php echo Beer::lowestAlcStrength($db); ?>" />
            		</div>
              <!--</form>-->
              <!--<form name="alcHigh" method="POST">-->
            		<div class="form-group col-md-6 text-right">
            		  <label>Max</label>
            		  <input type="number" class="form-control" step="0.01" onchange="alc.submit()" placeholder="<?php echo Beer::HighestAlcStrength($db); ?>" />
            		</div>
              <!--</form>-->
        		</div>
            </form>
      		</div> <!-- card-body.// -->
      	</div>
      </article> <!-- card-group-item.// -->

      <!-- fourth area for the review -->
      <article class="card-group-item">
      	<header class="card-header">
      		<h6 class="title">Bewertung (Kronkorken) </h6>
      	</header>
      	<div class="filter-content">
      		<div class="card-body">
      		<div class="form-row">
      		<div class="form-group col-md-6">
      		  <label>Min</label>
      		  <input type="number" class="form-control" step="0.01" placeholder="0">
      		</div>
      		<div class="form-group col-md-6 text-right">
      		  <label>Max</label>
      		  <input type="number" class="form-control" step="0.01" placeholder="10">
      		</div>
      		</div>
      		</div> <!-- card-body.// -->
      	</div>
      </article> <!-- card-group-item.// -->

    </div> <!-- card.// -->

  </div>

  <div class="col-7">

    <?php

    // display the beers if there are any
    if($num>0){

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract one beer
        extract($row,EXTR_PREFIX_ALL,'beer');
        $type->setId($beer_type_id);
        $type->readName();
        $avg_rating = number_format(Review::getAVGRating($db,$beer_id),1);
        $rating_text = ($avg_rating == 0) ? 'Noch keine Bierwertungen vorhanden.' : $avg_rating.'/10 Kronkorken';
        $image = $beer_image;
        if(($image != '') AND (file_exists('../uploads/' . $image))){
          $image = '../uploads/' . $beer_image;
        } else {
          $image = "../Assets/beer_empty.png";
        }
        ?>
        <a href="<?php echo "beer_details.php?name=".urlencode($beer_name);?>" class="text-dark card-link">
          <table>
            <tr>
              <td rowspan="3"><img src="<?php echo $image; ?>" width="65" height="65" alt="Fehler" /></td>
              <td rowspan="3" width="5"></td>
              <td><b><?php echo $beer_name; ?></b></td>
            </tr>
            <tr>
              <td>Sorte: <?php echo $type->getName(); ?><br/></td>
            </tr>
            <tr>
              <td>durchschnittliche Bewertung: <?php echo $rating_text ?></td>
            </tr>
          </table>
        </a><br/>
        <?php
      }

      // the page where this paging is used
      $page_url = "index.php?";

      // count all products in the database to calculate total pages
      $total_rows = $beer->countAll();

      // paging buttons here
      if ($total_rows > $records_per_page){
        include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/paging.php';
      }
    }

    // tell the user there are no beers
    else{
        echo "<br><div class='alert alert-info'>Es wurde kein Bier gefunden.</div>";
    }

    ?>

  </div>

  <div class='right-button-margin col-2'>
    <!-- Only logged in users can add a new beer -->
    <?php
    if (isset($_SESSION['session_id'])) {
      $database = new Database();
      $db = $database->getConnection();
      $loggedin_user = new user($db);
      $loggedin_user->setId($_SESSION['session_id']);
      ?>
      <a href='create_beer.php' class='btn btn-secondary pull-right'>Neues Bier brauen</a>
      <?php
    }
    ?>
  </div>

</div>
<?php

// set page footer
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/footer.php';
?>
