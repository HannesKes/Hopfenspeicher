<?php
  session_start();
  $_SESSION['LastPage'] = $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
  include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/db.php';
  
 ?>
 <!DOCTYPE html>
<html>
<head>
    <title>Bier Übersicht</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Hopfenspeicher/Style/customStyle.css">
  </head>
  <body>
    <?php include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/header.php';?>

    <!-- Page Content-->
    <div class="container">
      <br/>
      <h2 align="center">Übersicht aller Biere</h2>
      <!--
      <div class="">
        <div style="float:left;margin-right:5px;">
          <input type="button" dojoType="dijit.form.Button" value="neues Bier hinzufügen">
        </div>
        <div>
        -->
          <center>
            <b>Sortierung: </b>
            <select>
              <option value="alph">Alphabetisch</option>
              <option value="zufall">Zufällig</option>
              <option value="bewAsc">Bewertung aufsteigend</option>
              <option value="bewDesc">Bewertung absteigend</option>
              <option value="anzBewDesc">Anzahl Bewertungen absteigend</option>
            </select>
          </center>
          <!--
        </div>
      </div>
    -->
      <br/>
    <div class="uebersichtLinks" align="center" style="border:2px solid black; background-color:#FFCC50; height:495; width:170; float:left">
        <b><u>Filter</u></b><br/><br/>
        Brauerei:
        <select>
          <option value="alleBr">Alle</option>
          <option value="boelkstoff">Bölkstoff</option>
          <option value="veltins">Veltins</option>
          <option value="duff">Duff</option>
        </select>
        <br/><br/>
        Sorte:
        <select>
          <option value="alleSorten">Alle</option>
          <option value="pils">Pilsener</option>
          <option value="weizen">Weizen</option>
          <option value="dreck">Dreckszeug</option>
        </select>
        <br/><br/>
        Zutaten:
        <br/>
        <div align="left">
          <input type="checkbox" name="zutat" value="wasser">
          Wasser
          <br/>
          <input type="checkbox" name="zutat" value="blumenerde">
          Blumenerde
          <br/>
          <input type="checkbox" name="zutat" value="hefe">
          Hefe
          <br/>
          <input type="checkbox" name="zutat" value="apfelsaft">
          Apfelsaft
          <br/>
          <input type="checkbox" name="zutat" value="tomatenmark">
          Tomatenmark
        </div>
        <br/><br/>
        Alkoholgehalt: <br/>
        <div class="inputAlkohol" align=center>
          <input id="vonAlk" type="text" size="1" value="0,0" />
          -
          <input id="bisAlk" type="text" size="1" value="15,0" />
        </div>
        <br/>
        Bewertung (Kronkorken): <br/>
        <div class="inputBewertung" align=center>
          <input id="vonBw" type="text" size="1" value="1" />
          -
          <input id="bisBw" type="text" size="1" value="10" />
        </div>
    </div>
    <div class="uebersichtMitte", align="left", style="width:410; margin-left:20; float:left">
      <?php
      $datensatzBiere = getBierData();

      foreach($datensatzBiere as $Bier) {
        $BierID = $Bier['ID'];
        $sql = "SELECT AVG(bewertung) as AVGBewertung FROM Bewertungen WHERE (Bier_ID=$BierID)";
        $ergBewertung = $connection->query($sql) or die($connection->error);
        $erg = $ergBewertung->fetch_assoc();
        $AVGBewertung = ROUND($erg['AVGBewertung'],1);
        $brewery = str_replace(' ','_',$Bier['Brauerei']);
        $Sorte = str_replace(' ','_',$Bier['Sorte']);
       ?>
       <a href="<?php echo 'bierDetailUebersicht.php?Brauerei='.$brewery.'&Sorte='.$Sorte?>" style="text-decoration:none">
        <table>
          <tr>
            <td rowspan="3"><img src="../bild.php?BildNr=<?php echo $Bier['Bild_ID']; ?>" width="60" height="60" alt="Fehler" /></td>
            <td><b><?php echo $Bier['Name']; ?></b></td>
          </tr>
          <tr>
            <td>Sorte: <?php echo $Bier['Sorte']; ?><br/></td>
          </tr>
          <tr>
            <td>durchschnittliche Bewertung: <?php echo $AVGBewertung ?>/10 Kronkorken</td>
          </tr>
       </table>
      </a><br/>
       <?php } ?>
    </div>
    <div align="center" style="margin-left:20; float:left">
    <div>
      <a href=/Hopfenspeicher/Biere/bierHinzufuegen.php>
      <input type="button" dojoType="button" value="neues Bier hinzufügen">
      </a>
    </div><br/>
    <div class="uebersichtRechts", align="center"; style="border:2px solid black; height:495; width:170; background-color:#FFCC50">
      <FONT SIZE="4"><center><b><u>Beste Bewertung</u></b></center></FONT><br/>
      <table border="2">
        <tr>
          <td>Herbert Gulsch</td>
          <td>10/10</td>
        </tr>
        <tr>
          <td>Adelskronen Premium Pils</td>
          <td>Bruda das ballert</td>
        </tr>
      </table>
      <br/>
      <table border="2">
        <tr>
          <td>Der Henne</td>
          <td>10/10</td>
        </tr>
        <tr>
          <td>Adelskronen Premium Pils</td>
          <td>Geiler Bölkstoff</td>
        </tr>
      </table>
      <br/>
      <FONT SIZE="4"><center><b><u>neueste Biere</u></b></center><br/></FONT>
      <table border="2">
        <tr>
          <td>Herbert Gulsch</td>
          <td>10/10</td>
        </tr>
        <tr>
          <td>Adelskronen Premium Pils</td>
          <td>Bruda das ballert</td>
        </tr>
      </table>
      <br/>
      <table border="2">
        <tr>
          <td>Der Henne</td>
          <td>10/10</td>
        </tr>
        <tr>
          <td>Adelskronen Premium Pils</td>
          <td>Geiler Bölkstoff</td>
        </tr>
      </table>
      <br/>
    </div>
    </div>
    <br/>
  </div>
    <!--footer -->
  <?php include_once $_SERVER["DOCUMENT_ROOT"] . '/Hopfenspeicher/Extras/footer.php';?>
</body>
</html>
