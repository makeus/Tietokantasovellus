<?php 
  session_start();
  if($_SESSION["admin"] == 't'){
   include("../yhteys.php");
   $kysely = pg_prepare($yhteys, "muokkaus", 'UPDATE Käyttäjä SET Käyttäjänimi=$1, Sähköposti=$2, Ylläpitäjä=$3 WHERE Käyttäjänimi=$4');
   $kysely = pg_execute($yhteys, "muokkaus", array($_POST["käyttäjänimi"], $_POST["sähköposti"], $_POST["admin"], $_POST["vanhakäyttäjänimi"]));
   header("Location: admin.php?p=3");
  }
  else {
   header('HTTP/1.1 403 Forbidden');
  }
?>
