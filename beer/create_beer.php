<?php

// include database and object files
include_once '../Extras/db.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/beer.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/brewery.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/type.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/ingredient.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/beer_ingredient.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/images.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// pass connection to objects
$beer = new Beer($db);
$type = new Type($db);
$brewery = new brewery($db);
$ingredient = new Ingredient($db);

// set page headers
$page_title = "Bier hinzufügen";

//You may not be on this page when logged out
$redirect_when_loggedin = false;
$redirect_when_loggedout = true;
$redirect_page = 'index.php';

include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';

if($_POST){

  // set product property values
  $beer->setName($_POST['name']);
  $brewery->setName($_POST['brewery']);
  $brewery->readOne();
  $beer->setBrewery($brewery->getId());
  $beer->setDescription($_POST['description']);
  $beer->setAlcstrength($_POST['alcStrength']);
  $type->setName($_POST['type']);
  $type->readOne();
  $beer->setType_id($type->getId());

  $image=!empty($_FILES["image"]["name"])
        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]) : "";
  $beer->setImage($image);

  // create the product
  if($beer->create()){
    //echo "<div class='alert alert-success'>Das Bier wurde hinzugefügt.</div>";
    // try to upload the submitted file
    // uploadPhoto() method will return an error message, if any.
    echo uploadImage($image);

    $ingredient_array = explode(',',$_POST['ingredients']);
    foreach ($ingredient_array as $ingredient_name) {
      $beer_ingredient = new Beer_Ingredient($db);

      $ingredient->setId(null);
      $ingredient->setName($ingredient_name);
      $ingredient->readOne();

      $beer_ingredient->setIngredient_id($ingredient->getId());
      $beer_ingredient->setBeer_id($beer->getId());
      if (!$beer_ingredient->create()){
        echo "fail";
      }
    } //end foreach

    header('Location: beer_details.php?name='.urlencode($beer->getName()));
  } else { //could not create beer
    print_r($db->errorInfo());?>
    <div class='alert alert-danger'>Das Bier konnte nicht hinzugefügt werden.</div>
<?php }
} ?>

<link href="/Hopfenspeicher/Extras/jquery.flexdatalist.min.css" rel="stylesheet" type="text/css">
<!-- HTML form for creating a product -->
<h1 align="center">Fülle die Fässer mit deinem Bier</h1>
<a href="index.php"><button class="btn btn-secondary">Zurück</button></a></p>
<h3>Bitte gib alle Informationen zu dem Bier ein.</h3>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" autocomplete="off">
    <table class='table table-hover table-bordered'>
        <tr>
            <td>Name</td>
            <td>
              <input type='text' name='name' class='form-control' data-min-length='1' placeholder='Name' required/>
            </td>
        </tr>

        <tr>
            <td>Brauerei</td>
            <td>
                <input type='text' placeholder='Brauerei' class='flexdatalistBrewerys form-control' data-min-length='1' data-selection-required='true' list='brewerys' name='brewery'>
            </td>
        </tr>

        <tr>
            <td>Sorte</td>
            <td>
              <input type='text' placeholder='Sorte' class='flexdatalistTypes form-control' data-min-length='1' data-selection-required='true' list='types' name='type'>
            </td>
        </tr>

        <tr>
            <td>Alkoholgehalt</td>
            <td>
              <input type='number' placeholder='Alkoholgehalt' class='form-control' data-min-length='1' min="0" max="99.9" step="0.1" data-selection-required='true' name='alcStrength'>
            </td>
        </tr>

        <tr>
            <td>Beschreibung</td>
            <td><textarea name='description' class='form-control' placeholder='Beschreibung'></textarea></td>
        </tr>

        <tr>
            <td>Zutaten</td>
            <td>
              <input type='text' placeholder='Zutaten' class='flexdatalistIngredients form-control' data-min-length='1' list='ingredients' name='ingredients'/>
            </td>
        </tr>

        <tr>
            <td>Bild</td>
            <td><input type="file" class="form-control-file" accept=".png,.jpg,.jpeg,.gif" name="image"/></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="reset" class="btn btn-danger" name="reset">Eingaben zurücksetzen</button>
                <button type="submit" class="btn btn-success" name="submit">Bier brauen</button>
            </td>
        </tr>
    </table>
</form>

<!-- Build the datalists from the sql statements-->
<datalist id="brewerys">
<?php $stmt = $brewery->readAll();
while ($row_brewery = $stmt->fetch(PDO::FETCH_ASSOC)):
  extract($row_brewery,EXTR_PREFIX_ALL,'brewery');?>
  <option value="<?php echo $brewery_name ?>"><?php echo $brewery_name ?></option>
<?php endwhile; ?>
</datalist>

<datalist id="types">
<?php $stmt = $type->readAll();
while ($row_type = $stmt->fetch(PDO::FETCH_ASSOC)):
  extract($row_type,EXTR_PREFIX_ALL,'type');?>
  <option value="<?php echo $type_name ?>"><?php echo $type_name ?></option>
<?php endwhile; ?>
</datalist>


<datalist id="ingredients">
<?php $stmt = $ingredient->readAll();
while ($row_ingredient = $stmt->fetch(PDO::FETCH_ASSOC)):
  extract($row_ingredient,EXTR_PREFIX_ALL,'ingredient');?>
  <option value="<?php echo $ingredient_name ?>"><?php echo $ingredient_name ?></option>
<?php endwhile; ?>
</datalist>

<script src="/Hopfenspeicher/Extras/jquery.js"></script>
<script src="/Hopfenspeicher/Extras/jquery.flexdatalist.min.js"></script>
<script>
$('.flexdatalistBrewerys').flexdatalist({
     selectionRequired: true,
     minLength: 0,
     noResultsText: '<a href="index.php">Diese Brauerei anlegen</a>' //Todo
});
$('.flexdatalistTypes').flexdatalist({
     selectionRequired: true,
     minLength: 1,
     noResultsText: '<a href="index.php">Diese Sorte anlegen</a>' //Todo
});
$('.flexdatalistIngredients').flexdatalist({
     selectionRequired: true,
     minLength: 1,
     multiple: true,
     toggleSelected: true,
     noResultsText: '<a href="index.php">Diese Zutat anlegen</a>' //Todo
});
</script>
<?php
// footer
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/footer.php'
?>
