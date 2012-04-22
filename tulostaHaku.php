<?php

if (!session_is_registered("käyttäjänimi")) {
    header("HTTP/1.1 403 Forbidden");
} else {

    include("logiikka/kategoriafunktiot.php");
    include("logiikka/viestifunktiot.php");

    /*
     * Tarkistaa, että käyttäjä saa nähdä hakutuloksena tulleen viestin ja kutsuu printaaViesti()
     */
    $kayttajanimi = $_SESSION["käyttäjänimi"];
    $nakyvyys = getNakyvyys($kayttajanimi);

    $hakunimi = escape($_POST["hakusana"]);
    $hakusana = escape($_POST["hakusana"]);
    $hakutulokset = getHakutulokset($hakunimi, $hakusana);
    echo "<br/>";
    echo "<div  id=\"viestijavastauksetlaatikko\">";
    if (!empty($hakutulokset)) {
        foreach ($hakutulokset as $rivi) {
            if ((!empty($rivi)) && (in_array($rivi["kategoria"], $nakyvyys))) {
                echo printtaaViesti($rivi["id"], $rivi["id"]);
            }
        }
    } else {
        echo "<p>Ei tuloksia</p>";
    }
    echo "</div>";
}

/*
 * Tulostaa hakutuloksena tulleen viestin.
 */

function printtaaViesti($id, $eka) {
    $viesti = getViesti($id);
    echo "  <p class=\"kategoria\">" . $viesti["otsikko"] . "</p>";
    echo "<p class=\"Kirjoittaja\"><strong>" . $viesti["kirjoittaja"] . "</strong> (" . date("d.m.y H:i:s", strtotime($viesti["aika"])) . ") " . $viesti["otsikko"];
    if ($_SESSION["admin"] == 't' || $viesti["kirjoittaja"] == $_SESSION["käyttäjänimi"]) {
        echo "<a class=\"poistolink\" href=# onclick='varmista(\"toiminnot/poistaViesti.php?id=" . $id . "\", \"Oletko varma, että haluat poistaa viestin?\")'>poista</a></p>";
    }

    echo "<p>" . $viesti["teksti"] . "</p>";
    $lukeneet = getLukeneet($id);
    echo "<a class=\"naytalukeneet\" id=\"link" . $id . "\" onclick='naytaLukeneet(" . $id . ")'>Näytä</a>";
    echo "<p class=\"lukeneet\" id=\"" . $id . "\"><strong>Viestin lukeneet:</strong>  ";
    if (!empty($lukeneet)) {
        foreach ($lukeneet as $i => $lukija) {
            if ($i == 0) {
                echo $lukija;
            } else {
                echo ", " . $lukija;
            }
        }
    }
    echo "</p>";
}

?>
