<?php 
  session_start();
  if($_SESSION["admin"] == 't'){
   include("../yhteys.php");
   $kayttaja = pg_query($yhteys, "SELECT käyttäjänimi FROM Käyttäjä WHERE Käyttäjänimi='". $_POST["käyttäjänimi"]. "'");
   if (($tulos = pg_fetch_row($kayttaja)) != NULL) {
    if(isset($_POST["poista"])){
     $kysely = pg_prepare($yhteys, "poisto", 'DELETE FROM Käyttäjä WHERE Käyttäjänimi=$1');
     $kysely = pg_execute($yhteys, "poisto", array($_POST["käyttäjänimi"]));
     header("Location: admin.php?p=3");
    }
    else {
     $kysely = pg_query($yhteys, "SELECT käyttäjänimi, sähköposti, ylläpitäjä FROM Käyttäjä WHERE Käyttäjänimi='". $_POST["käyttäjänimi"]. "'");
     $kayttaja = pg_fetch_row($kysely);
     $nimi = $kayttaja[0];
     $sahkoposti = $kayttaja[1];
     $yllapitaja = $kayttaja[2];
     header("Location: admin.php?p=3&muokkaa=yes&nimi=".urlencode($nimi)."&sahkoposti=".urlencode($sahkoposti)."&yllapitaja=".urlencode($yllapitaja));
    }
   }
   else {
    $kayttaja1 = $_POST["käyttäjänimi"];
    header("Location: admin.php?p=3&m=$kayttaja1");
    }
   
  }
  else {
   header('HTTP/1.1 403 Forbidden'); 
  }
?>
