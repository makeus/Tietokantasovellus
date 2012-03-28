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
    echo "<p>Käyttäjää ei löytynyt</p>";
    echo "<br><p>Samankaltaiset nimet</p>";
    $kayttajat = pg_prepare($yhteys, "haku" ,'SELECT Käyttäjänimi FROM Käyttäjä WHERE Käyttäjänimi LIKE $1');
    $kayttajat = pg_execute($yhteys, "haku", array('%' . $_POST["käyttäjänimi"] . '%'));
    while($kayttaja = pg_fetch_array($kayttajat)) {
     echo "<br><p>".$kayttaja[0]."</p>";
    }
   }
  }
  else {
   header('HTTP/1.1 403 Forbidden'); 
  }
?>
