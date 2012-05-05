<?php

if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {

    /*
     * Hakee kaikki käyttäjät
     */

    function getKayttajat() {
        include_once '../tietokanta/kyselyt.php';
        $return = selectorder("*", "Käyttäjä", "Käyttäjänimi");
        return $return;
    }

    /*
     * Hakee samanlaiset käyttäjät
     */

    function getSamanlaiset($nimi) {
        include_once '../tietokanta/kyselyt.php';
        $return = select("*", "Käyttäjä", "Käyttäjänimi LIKE '%$nimi%'");
        return $return;
    }

    /*
     * Hakee tietyn käyttäjän
     */

    function getKayttaja($nimi) {
        include_once '../tietokanta/kyselyt.php';
        $return = select("*", "Käyttäjä", "Käyttäjänimi = '$nimi'");
        return $return[0];
    }

}
?>
