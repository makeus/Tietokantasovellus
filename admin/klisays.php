<?php
  session_start();
  include("../yhteys.php");
  include("tarkistukset.php");
  $nimi = $_POST['kayttajanimi'];
  if(tarkistaKayttaja($nimi)) {
    header("Location: admin.php?p=4&e=$nimi");
  } else {
    $kysely = pg_prepare($yhteys, "lisays", 'INSERT INTO Käyttäjä (Käyttäjänimi, Sähköposti, Salasana, Ylläpitäjä) VALUES ($1, $2, $3, $4)');
    $kysely = pg_execute($yhteys, "lisays", array($_POST["kayttajanimi"], $_POST["sahkoposti"], $_POST["salasana"], $_POST["admin"]));
    header("Location: admin.php?p=4&ok=$nimi");
  }
?>
