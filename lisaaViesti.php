<?php
  session_start();
  include("yhteys.php");
  $kayttajanimi = $_SESSION["käyttäjänimi"];
  if(isset($_POST["vastaus"])) {
    $kysely = pg_prepare($yhteys, "lisays", 'INSERT INTO Viesti (Aika, Otsikko, Teksti, Kategoria, Viestinlukeneet, Kirjoittaja, Vastaus) 
                                                  VALUES (NOW(), $1, $2, $3, Array[$4], $5, $6)');
    $kysely = pg_execute($yhteys, "lisays", array($_POST["otsikko"], $_POST["teksti"], $_POST["kategoria"], $kayttajanimi, $kayttajanimi, $_POST["vastaus"]));
    header("Location:/");
  } 
  else {

  $kysely = pg_prepare($yhteys, "lisays", 'INSERT INTO Viesti (Aika, Otsikko, Teksti, Kategoria, Viestinlukeneet, Kirjoittaja) 
                                                  VALUES (NOW(), $1, $2, $3, Array[$4], $5)');
  $kysely = pg_execute($yhteys, "lisays", array($_POST["otsikko"], $_POST["teksti"], $_POST["kategoria"], $kayttajanimi, $kayttajanimi));
  header("Location:/");
  }
?>
