<?php

if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {
    
    /*
     * Hakee kaikki ryhmät
     */

    function getRyhmat() {
        include_once '../tietokanta/kyselyt.php';
        $return = selectorder("*", "Ryhmä", "id");
        return $return;
    }

    /*
     * Hakee kaikki ryhmän jäsenet
     */

    function getRyhmanJasenet($ryhmannimi) {
        include_once '../tietokanta/kyselyt.php';
        $return = select("Ryhmänjäsen", "RyhmäNimi", "ryhmännimi = ('$ryhmannimi')");
        return $return;
    }

    /*
     * Hakee ryhmännimen id:n perusteella
     */

    function getRyhmannimi($id) {
        include_once '../tietokanta/kyselyt.php';
        $ryhmat = select("RyhmänNimi", "Ryhmä", "id=('$id')");
        $ryhmannimi = $ryhmat[0];
        return $ryhmannimi["ryhmännimi"];
    }

    /*
     * Hakee tietyt käyttäjät, mitkä toteuttavat tietyn ehdon
     */

    function getKayttajat($ehto) {
        $return = select("*", "Käyttäjä", $ehto . "ORDER BY käyttäjänimi");
        return $return;
    }

    /*
     * Hakee kaikki käyttäjät
     */

    function getKayttajatAll() {
        $return = selectorder("*", "Käyttäjä", "käyttäjänimi");
        return $return;
    }

}
?>
