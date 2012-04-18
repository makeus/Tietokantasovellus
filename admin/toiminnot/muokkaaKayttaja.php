<?php

session_start();
if ((session_is_registered("käyttäjänimi")) and ($_SESSION["admin"] == 't')) {

    include_once ("../../tietokanta/kyselyt.php");
    include_once ("../logiikka/tarkistukset.php");
    
    $nimi = escape($_POST['käyttäjänimi']);
    $sahkoposti = escape($_POST["sähköposti"]);
    $yllapitaja = escape($_POST["admin"]);
    $vanha = escape($_POST["vanhakäyttäjänimi"]);
    
    if (tarkistaKayttaja($nimi)) {
        header("Location: ../admin.php?p=3&muokkaa=$nimi&e=$nimi");
    } else {
        update("Käyttäjä", "Käyttäjänimi='$nimi', Sähköposti='$sahkoposti', Ylläpitäjä='$yllapitaja' WHERE Käyttäjänimi='$vanha'");
        header("Location: ../admin.php?p=3");
    }
} else {
    header('HTTP/1.1 403 Forbidden');
}
?>
