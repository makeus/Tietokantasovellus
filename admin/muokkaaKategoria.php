<?php 
  session_start();
  if($_SESSION["admin"] == 't'){
   include("../yhteys.php");
   $nimi = $_POST['nimi'];
   if(tarkistaKategorianNimi($nimi)) {
    header("Location: admin.php?p=5&e=$nimi");
    } 
   else {
     $kysely = pg_prepare($yhteys, "muokkaus", 'UPDATE Kategoria SET KategorianNimi=$1, Näkyvyys=$2 WHERE Id=$3');
     $kysely = pg_execute($yhteys, "muokkaus", array($_POST["nimi"], $_POST["nakyvyys"], $_POST["id"]));
     header("Location: admin.php?p=5");
   }
  }
  else {
   header('HTTP/1.1 403 Forbidden');
  }
?>
