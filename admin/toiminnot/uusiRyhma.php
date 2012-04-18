<?php

session_start();
if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {
    include_once ("../../tietokanta/kyselyt.php");
    include_once ("../logiikka/tarkistukset.php");

    $nimi = $_POST['nimi'];
    $nimi = escape($nimi);
    if (tarkistaRyhmaNimi($nimi)) {
        header("Location: ../admin.php?p=2&e=$nimi");
    } else {

        insert("Ryhmä (Ryhmännimi)", "'$nimi'");
        $ryhmat = select("id", "Ryhmä", "RyhmänNimi=('$nimi')");
        $ryhmanid = $ryhmat[0];
        $id = $ryhmanid["id"];

        header("Location: ../admin.php?p=1&m=$id");
    }
}
?>
