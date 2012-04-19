<?php

session_start();
if (session_is_registered("käyttäjänimi")) {
    include_once("../tietokanta/kyselyt.php");

    $otsikko = escape($_POST["otsikko"]);
    $teksti = escape($_POST["teksti"]);
    $kayttajanimi = $_SESSION["käyttäjänimi"];

    $kategoria = $_POST["kategoria"];
    settype($kategoria, int);

    // Jos on vastaus
    if (isset($_POST["vastaus"])) {

        $vastaus = $_POST["vastaus"];
        settype($vastaus, int);

        insert("Viesti (Aika, Otsikko, Teksti, Kategoria, Viestinlukeneet, Kirjoittaja, Vastaus)", "NOW(), '$otsikko', '$teksti', '$kategoria', Array['$kayttajanimi'], '$kayttajanimi', '$vastaus'");

        if (isset($_POST["palaaminen"])) {
            $palaaminen = $_POST["palaaminen"];
            header("Location:/?p=3&id=$palaaminen");
        } else {
            header("Location:/");
        }
    }

    // Jos ei :D!
    else {
        insert("Viesti (Aika, Otsikko, Teksti, Kategoria, Viestinlukeneet, Kirjoittaja)", "NOW(), '$otsikko', '$teksti', '$kategoria', Array['$kayttajanimi'], '$kayttajanimi'");
        if (isset($_POST["palaaminen"])) {
            $palaaminen = $_POST["palaaminen"];
            header("Location:/?p=3&id=$palaaminen");
        } else {
            header("Location:/");
        }
    }
} else {
    header("HTTP/1.1 403 Forbidden");
}
?>
