<?php 
  session_start();
  if($_SESSION["admin"] == 't'){
   include("../yhteys.php");
   $kayttaja = pg_query($yhteys, "SELECT käyttäjänimi FROM Käyttäjä WHERE Käyttäjänimi='". $_GET["poista"]. "'");
   $kysely = pg_prepare($yhteys, "poisto", 'DELETE FROM Käyttäjä WHERE Käyttäjänimi=$1');
   $kysely = pg_execute($yhteys, "poisto", array($_GET["poista"]));
   header("Location: admin.php?p=3");
   }
  else {
   header('HTTP/1.1 403 Forbidden'); 
  }
?>
