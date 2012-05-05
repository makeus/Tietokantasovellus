<?php

/*
 * Poistaa käyttäjän, mikäli poistettava löytyy ja poistettava ei ole poistaja itse
 */
session_start();
if ((session_is_registered("käyttäjänimi")) and ($_SESSION["admin"] == 't')) {

    include_once ("../../tietokanta/kyselyt.php");

    $nimi = escape($_GET["poista"]);
    if ($nimi != $_SESSION["käyttäjänimi"]) {
        $onnistunut = delete("Käyttäjä", "Käyttäjänimi='$nimi'");
        if ($onnistunut) {
            header("Location: ../admin.php?p=3&po=f&nimi=$nimi");
        } else {
            header("Location: ../admin.php?p=3&po=$nimi");
        }
    } else {
        header("Location: ../admin.php?p=3&po=f");
    }
} else {
    header('HTTP/1.1 403 Forbidden');
}
?>
