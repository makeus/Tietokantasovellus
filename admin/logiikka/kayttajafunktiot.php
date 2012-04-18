<?php

if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {

    function getKayttajat() {
        include_once '../tietokanta/kyselyt.php';
        $return = selectorder("*", "Käyttäjä", "Käyttäjänimi");
        return $return;
    }

    function getSamanlaiset($nimi) {
        include_once '../tietokanta/kyselyt.php';
        $return = select("*", "Käyttäjä", "Käyttäjänimi LIKE '%$nimi%'");
        return $return;
    }

    function getKayttaja($nimi) {
        include_once '../tietokanta/kyselyt.php';
        $return = select("*", "Käyttäjä", "Käyttäjänimi = '$nimi'");
        return $return[0];
    }

}
?>
