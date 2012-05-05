<?php

if (!session_is_registered("käyttäjänimi")) {
    header("HTTP/1.1 403 Forbidden");
} else {

    include_once("logiikka/kategoriafunktiot.php");
    include_once("logiikka/viestifunktiot.php");

    $kayttajanimi = $_SESSION["käyttäjänimi"];
    $nakyvyys = getNakyvyys($kayttajanimi);

    if (empty($nakyvyys)) {
        echo "<p id=\"eiviesteja\">Ei mitään, minne kirjoittaa :L</p>";
    } else {
        /*
         * Minkätyypin viesti
         * Vastataanko viestiin...
         * Vastataanko ketjuun..
         * Ulkoasu vaihtelee
         */

        if (isset($_GET["v"])) {
            $vastausid = $_GET["v"];
            settype($vastausid, 'int');
            vastattavateksti($vastausid);
        } elseif (isset($_GET["id"])) {
            $vastausid = $_GET["id"];
            settype($vastausid, 'int');
            ketjuvastaus($vastausid);
        } else {
            echo "<form method=\"post\" action=\"toiminnot/lisaaViesti.php\"><br/>\n";
            echo "<table>\n";
            echo "  <tr>\n";
            echo "   <td colspan=\"2\" class=\"kategoria\">Kirjoita Viesti</td>\n";
            echo "  </tr>\n";
            echo "  <tr>\n";
            echo "   <td class=\"viestilotsikko\">Otsikko:</td>\n";
            echo "   <td><input id=\"kirjoitaviestiotsikko\" type=\"text\" name=\"otsikko\" maxlength=\"64\" required autofocus /></td>\n";
            echo "  </tr>\n";
            echo "  <tr>\n";
            echo "   <td class=\"viestilotsikko\">Kategoria:</td>\n";
            echo "   <td><select id=\"kategoriavaihtoehdot\" name=\"kategoria\">\n";

            /*
             * Kategoriavaihtoehdot
             */
            foreach ($nakyvyys as &$kid) {
                $kategorianimi = getKategoriannimi($kid);
                echo "    <option value=\"" . $kid . "\">" . $kategorianimi . "</option>\n";
            }

            echo "   </select></td>\n";
            echo "  </tr>\n";
        }
        if (isset($_GET["pal"])) {
            echo "<input type=\"hidden\" name=\"palaaminen\" value=\"" . $_GET["pal"] . "\" />";
        }
        if (isset($_GET["id"])) {
            echo "<input type=\"hidden\" name=\"palaaminen\" value=\"" . $_GET["id"] . "\" />";
        }
        echo "  <tr>\n";
        echo "    <td class=\"viestilotsikko\">Viesti:</td>\n";
        echo "    <td><textarea name=\"teksti\" required rows=\"15\" cols=\"70\" tabindex=\"0\" ";
        if (isset($_GET["v"])) {
            echo "autofocus";
        } echo "></textarea></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td class=\"viestilotsikko\"></td>\n";
        echo "    <td><input type=\"submit\" name=\"Lähetä!\" /></td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        echo "</form>\n";
    }
}
/*
 * Tulostaa vastattavan viestin ja viestilomakkeen ilman kategoriaa
 */

function vastattavateksti($id) {
    $viesti = getViesti($id);
    $kategoriannimi = getKategoriannimi($viesti["kategoria"]);

    echo "<table>\n";
    echo "  <tr>\n";
    echo "   <td colspan=\"3\" class=\"kategoria\">" . $viesti["otsikko"] . "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "   <td colspan=\"1\" class=\"pikkuteksti\">" . $viesti["kirjoittaja"] . " (" . date("d.m.y H:i:s", strtotime($viesti["aika"])) . ")</td>\n";
    echo "   <td colspan=\"1\" class=\"pikkuteksti\">" . $kategoriannimi . "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "   <td id=\"isoteksti\" colspan=\"2\">" . $viesti["teksti"] . "<td>\n";
    echo "  </tr>\n";
    echo "</table><br>\n";
    echo "<form method=\"post\" action=\"toiminnot/lisaaViesti.php\">";
    echo "<input type=\"hidden\" name=\"vastaus\" value=\"" . $viesti["id"] . "\" />\n";
    echo "<input type=\"hidden\" name=\"kategoria\" value=\"" . $viesti["kategoria"] . "\"/>\n";
    echo "<table>\n";
    echo "  <tr>\n";
    echo "   <td colspan=\"2\" class=\"kategoria\">Kirjoita Vastaus</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "   <td class=\"viestilotsikko\">Otsikko:</td>\n";
    echo "   <td><input id=\"kirjoitaviestiotsikko\" type=\"text\" name=\"otsikko\" maxlength=\"64\" value=\"Re: " . $viesti["otsikko"] . "\" required/></td>\n";
    echo "  </tr>\n";
}

/*
 * Tulostaa viestilomakkeen ilman kategoriaa
 */

function ketjuvastaus($id) {
    $viesti = getViesti($id);

    echo "<br/>";
    echo "<form method=\"post\" action=\"toiminnot/lisaaViesti.php\">";
    echo "<input type=\"hidden\" name=\"vastaus\" value=\"" . $viesti["id"] . "\" />\n";
    echo "<input type=\"hidden\" name=\"kategoria\" value=\"" . $viesti["kategoria"] . "\"/>\n";
    echo "<table>\n";
    echo "  <tr>\n";
    echo "   <td colspan=\"2\" class=\"kategoria\">Kirjoita Vastaus</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "   <td class=\"viestilotsikko\">Otsikko:</td>\n";
    echo "   <td><input id=\"kirjoitaviestiotsikko\" type=\"text\" name=\"otsikko\" maxlength=\"64\" value=\"Re: " . $viesti["otsikko"] . "\" required/></td>\n";
    echo "  </tr>\n";
}

?>
