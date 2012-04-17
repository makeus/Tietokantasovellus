<?php

if (session_is_registered("käyttäjänimi")) {
    session_start();
    include_once("../logiikka/viestifunktiot.php");
    include_once("../tietokanta/kyselyt.php");

    $viesti = getViesti($_GET["id"]);
    $kirjoittaja = $viesti["kirjoittaja"];
    $id = $viesti["id"];

    if ($_SESSION["admin"] == 't' || $kirjoittaja == $_SESSION["käyttäjänimi"]) {
        delete("Viesti", "id=('$id')");
    }
    header("Location: ../index.php");
} else {
    header("HTTP/1.1 403 Forbidden");
}
?>
