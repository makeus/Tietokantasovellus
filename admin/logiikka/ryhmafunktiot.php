<?php

if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {

    function getRyhmat() {
        include_once '../tietokanta/kyselyt.php';
        $return = selectorder("*", "Ryhmä", "id");
        return $return;
    }

    function getRyhmanJasenet($ryhmannimi) {
        include_once '../tietokanta/kyselyt.php';
        $return = select("Ryhmänjäsen", "RyhmäNimi", "ryhmännimi = ('$ryhmannimi')");
        return $return;
    }

    function getRyhmannimi($id) {
        include_once '../tietokanta/kyselyt.php';
        $ryhmat = select("RyhmänNimi", "Ryhmä", "id=('$id')");
        $ryhmannimi = $ryhmat[0];
        return $ryhmannimi["ryhmännimi"];
    }

    function getKayttajat($ehto) {
        $return = select("*", "Käyttäjä", $ehto . "ORDER BY käyttäjänimi");
        return $return;
    }

    function getKayttajatAll() {
        $return = selectorder("*", "Käyttäjä", "käyttäjänimi");
        return $return;
    }

}
?>
