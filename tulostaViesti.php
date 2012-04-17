<?php

include_once("logiikka/kategoriafunktiot.php");
include_once("logiikka/viestifunktiot.php");

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
        tulostaViesti($id);
        echo "</div>";
        include_once 'kirjoitaViesti.php';
    } else {
        echo "<p id=\"eiviesteja\">HEI!</p>";
    }
} else {
    echo "<p id=\"eiviesteja\">HEI!</p>";
}

/*
 * Merkataan viesti luetuksi, tulostetaan viesti ja kutsutaan rekursiivisesti kaikille vastauksille.
 */

function tulostaViesti($viestin_id) {
    merkkaaLuetuksi($viestin_id);
    printtaaViesti($viestin_id);
    $viestit = getVastaukset($viestin_id);
    if (!empty($viestit)) {
        foreach ($viestit as $rivi) {
            echo "<div class=\"viesti\">";
            tulostaViesti($rivi["id"]);
            echo "</div>";
        }
    }
}

function printtaaViesti($id) {
    $viesti = getViesti($id);
    echo "<p class=\"Kirjoittaja\">" . $viesti["kirjoittaja"] . " (" . date("d.m.y H:i:s", strtotime($viesti["aika"])) . ") " . $viesti["otsikko"] . "<a class=\"vastauslink\" href=\"/?p=2&v=" . $id . "\">vastaa</a></p>";
    echo "<p>" . $viesti["teksti"] . "</p>";
}

?>
