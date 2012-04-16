<?php

session_start();
include("yhteys.php");
$otsikko = pg_escape_string($yhteys, htmlspecialchars($_POST["otsikko"]));
$teksti = pg_escape_string($yhteys, htmlspecialchars($_POST["teksti"]));
$kayttajanimi = $_SESSION["käyttäjänimi"];

$kategoria = $_POST["kategoria"];
settype($kategoria, int);

// Jos on vastaus
if (isset($_POST["vastaus"])) {

    $vastaus = $_POST["vastaus"];
    settype($vastaus, int);

    $kysely = pg_prepare($yhteys, "lisays", 'INSERT INTO Viesti (Aika, Otsikko, Teksti, Kategoria, Viestinlukeneet, Kirjoittaja, Vastaus) 
                                                  VALUES (NOW(), $1, $2, $3, Array[$4], $5, $6)');
    $kysely = pg_execute($yhteys, "lisays", array($otsikko, $teksti, $kategoria, $kayttajanimi, $kayttajanimi, $vastaus));
    header("Location:/");
}

// Jos ei :D!
else {
    $kysely = pg_prepare($yhteys, "lisays", 'INSERT INTO Viesti (Aika, Otsikko, Teksti, Kategoria, Viestinlukeneet, Kirjoittaja) 
                                                  VALUES (NOW(), $1, $2, $3, Array[$4], $5)');
    $kysely = pg_execute($yhteys, "lisays", array($otsikko, $teksti, $kategoria, $kayttajanimi, $kayttajanimi));
    header("Location:/");
}
?>
