<?php

if (!session_is_registered("käyttäjänimi")) {
    header("HTTP/1.1 403 Forbidden");
} else {

    include("logiikka/kategoriafunktiot.php");
    include("logiikka/viestifunktiot.php");

    $kayttajanimi = $_SESSION["käyttäjänimi"];
    $nakyvyys = getNakyvyys($kayttajanimi);

    /*
     * Tarkistetaan, että käyttäjä saa katsoa viestin ja tulostetaan viesti.
     */

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        settype($id, 'int');
        $viesti = getViesti($id);
        if ((!empty($viesti)) && (in_array($viesti["kategoria"], $nakyvyys))) {
            echo "<br/>";
            echo "<div id=\"viestijavastauksetlaatikko\">";
            echo "  <p class=\"kategoria\">" . $viesti["otsikko"] . "</p>";
            tulostaViesti($id, $id);
            echo "</div>";
            include_once 'kirjoitaViesti.php';
        } else {
            echo "<p id=\"eiviesteja\">HEI!</p>";
        }
    } else {
        echo "<p id=\"eiviesteja\">HEI!</p>";
    }
}

/*
 * Merkataan viesti luetuksi, tulostetaan viesti ja kutsutaan samaa funktiota kaikille vastauksille.
 */

function tulostaViesti($viestin_id, $eka) {
    merkkaaLuetuksi($viestin_id, $_SESSION["käyttäjänimi"]);
    printtaaViesti($viestin_id, $eka);
    $viestit = getVastaukset($viestin_id);
    if (!empty($viestit)) {
        foreach ($viestit as $rivi) {
            echo "<div class=\"viesti\">";
            echo tulostaViesti($rivi["id"], $eka);
            echo "</div>";
        }
    }
}

/*
 * Tulostetaan viestin sisältö, aika, otsikko, kirjoittaja ja vastaa-nappi, sekä mikäli kirjoittaja tai ylläpitäjä, niin poista nappi.
 */

function printtaaViesti($id, $eka) {
    $viesti = getViesti($id);
    if ($_SESSION["admin"] == 't' || $viesti["kirjoittaja"] == $_SESSION["käyttäjänimi"]) {
        echo "<p class=\"Kirjoittaja\">" . $viesti["kirjoittaja"] .
        " (" . date("d.m.y H:i:s", strtotime($viesti["aika"])) . ") "
        . $viesti["otsikko"] .
        "<a class=\"vastauslink\" href=\"/?p=2&v=" . $id . "&pal=" . $eka . "\">vastaa</a>" .
        "<a class=\"poistolink\" href=# onclick='varmista(\"toiminnot/poistaViesti.php?id=" . $id . "\", \"Oletko varma, että haluat poistaa viestin?\")'>poista</a></p>";
        echo "<p>" . $viesti["teksti"] . "</p>";
    } else {
        echo "<p class=\"Kirjoittaja\">" . $viesti["kirjoittaja"] . " (" . date("d.m.y H:i:s", strtotime($viesti["aika"])) . ") " . $viesti["otsikko"] . "<a class=\"vastauslink\" href=\"/?p=2&v=" . $id . "\">vastaa</a></p>";
        echo "<p>" . $viesti["teksti"] . "</p>";
    }
}

?>
