<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/db.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/objects/beer.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$random_name = str_replace(' ','_',Beer::randomBeerName($db));

$url = 'beer_details.php?name='.urlencode($random_name);

header("Location: $url");
exit();
?>
