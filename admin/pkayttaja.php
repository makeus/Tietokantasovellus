<?php 
  session_start();
  if($_SESSION["admin"] == 't'){
   include("../yhteys.php");
   $kayttaja = pg_query($yhteys, "SELECT käyttäjänimi FROM Käyttäjä WHERE Käyttäjänimi='". $_POST["käyttäjänimi"]. "'");
   if (($tulos = pg_fetch_row($kayttaja)) != NULL) {
    $kysely = pg_prepare($yhteys, "poisto", 'DELETE FROM Käyttäjä WHERE Käyttäjänimi=$1');
    $kysely = pg_execute($yhteys, "poisto", array($_POST["käyttäjänimi"]));
   }
   else {
    $kayttaja1 = $_POST["käyttäjänimi"];
    header("Location: http://jeraiha.users.cs.helsinki.fi/admin/admin.php?p=3&m=$kayttaja1");
    }
   
  }
  else {
   header('HTTP/1.1 403 Forbidden'); 
  }
?>
