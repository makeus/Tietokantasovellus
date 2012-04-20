<?php

session_start();
if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {
    include_once ("../../tietokanta/kyselyt.php");
    include_once ("../logiikka/tarkistukset.php");
    
    function_exists('selectorder');
    
    $nimi = escape($_POST["kayttajanimi"]);
    $sahkoposti = escape($_POST["sahkoposti"]);
    $salasana = escape($_POST["salasana"]);
    $salasana = hash('sha256', $salasana);
    $yllapitaja = escape($_POST["admin"]);

    if (tarkistaKayttaja($nimi)) {
        header("Location: ../admin.php?p=4&e=$nimi");
    } else {
        insert("Käyttäjä (Käyttäjänimi, Sähköposti, Salasana, Ylläpitäjä)", "'$nimi', '$sahkoposti', '$salasana', '$yllapitaja'");
        header("Location: ../admin.php?p=4&ok=$nimi");
    }
}
?>
