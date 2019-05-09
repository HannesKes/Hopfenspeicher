<?php
  //Gibt alle Datensätze zu allen Bieren zurück
  function getBierData($BierID = NULL) {
    $connection = buildConnection();
    $datensatzBiere;

    if (is_null($BierID)) {
      $ergBiere = $connection->query("SELECT * FROM bier") or die($connection->error);
      $datensatzBiere = $ergBiere->fetch_all(MYSQLI_ASSOC);
    } else {
      $ergBiere = $connection->query("SELECT * FROM bier WHERE (ID = \"$BierID\")") or die($connection->error);
      $datensatzBiere = $ergBiere->fetch_assoc();
    }

    return $datensatzBiere;
  }

  //findet die ID des Bieres, dessen Name übergeben wurde
  function getBierIDByName($biername) {
    $connection = buildConnection();

    //Daten aus Datenbank holen
    $sql = "SELECT ID FROM bier WHERE (Name LIKE \"$biername\")";
    $ergBier = $connection->query($sql) or die($connection->error);
    $DatensatzBier = $ergBier->fetch_assoc();

    return $DatensatzBier['ID'];
  }
?>
