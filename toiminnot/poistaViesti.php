<?php

/*
 * Poistaa viestin tietokannasta, mikäli siihen on oikeus
 */

session_start();
if (session_is_registered("käyttäjänimi")) {

    include_once("../logiikka/viestifunktiot.php");
    include_once("../tietokanta/kyselyt.php");

    $viesti = getViesti2($_GET["id"]);
    $kirjoittaja = $viesti["kirjoittaja"];
    $id = $viesti["id"];
    settype($id, 'int');

    if ((($_SESSION["admin"] == 't') || ($kirjoittaja == $_SESSION["käyttäjänimi"])) && (isset($id)) && ($id != "")) {
        delete("Viesti", "id=('$id')");
    }
    header("Location: ../index.php");
} else {
    header("HTTP/1.1 403 Forbidden");
}
?>
