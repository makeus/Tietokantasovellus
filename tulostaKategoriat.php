<?php

include("tarkista.php");
include("logiikat/kategoriafunktiot.php");
include("logiikat/viestifunktiot.php");


if (count($nakyvyys) > 0) {
    echo "<table>\n";
    echo "  <thead>\n";
    echo "    <tr>\n";
    echo "     <th></th>\n";
    echo "     <th>Kirjoittaja</th>\n";
    echo "     <th>Viimeisin vastaus</th>\n";
    echo "  </thead>\n";
} else {
    echo "<p id=\"eiviesteja\">Ei viestejä :L</p>";
}

foreach ($nakyvyys as &$kid) {
    $kategorianimi = getKategoriannimi($kid);
    $otsikot = pg_query($yhteys, "SELECT otsikko, aika, kirjoittaja, id, viestinlukeneet FROM viesti where kategoria=('$kid') and vastaus is null order by aika desc");
    $ekarivi = pg_fetch_row($otsikot);


    // Jos ei viestejä kategoriassa, ei tulosteta mitään.

    if ($ekarivi != NULL) {
        echo "  <tr>\n";
        echo "    <td colspan=\"3\" class=\"kategoria\">" . $kategorianimi[0] . "</td>\n";
        echo "  </tr>\n";
        echo "  <tr class=\"otsikko\">\n";

        if (($ekarivi[4] != null) && (in_array($kayttajanimi, pg_array_parse($ekarivi[4], FALSE))) && etsiOnkoLukenut($kayttajanimi, $ekarivi[3])) {
            echo "    <td>";
        } else {
            echo "   <td class=\"lukematon\">";
        }
        echo "<a href=\"/?p=3&id=" . $ekarivi[3] . "\">" . $ekarivi[0] . "</a>\n";
        echo "     </td>\n";
        echo "     <td>" . $ekarivi[2] . "</td>\n";
        echo "     <td>" . date("d.m.y H:i:s", strtotime(etsiViimeisinViesti($ekarivi[3], $ekarivi[1]))) . "</td>\n";
        echo "  </tr>\n";

        while ($otsikko = pg_fetch_array($otsikot)) {
            echo "  <tr class=\"otsikko\">\n";

            if (($otsikko[4] != null) && (in_array($kayttajanimi, pg_array_parse($otsikko[4], FALSE))) && etsiOnkoLukenut($kayttajanimi, $otsikko[3])) {
                echo "    <td>";
            } else {
                echo "    <td class=\"lukematon\">";
            }
            echo "<a href=\"/?p=3&id=" . $otsikko[3] . "\">" . $otsikko[0] . "</a>\n";
            echo "    </td>\n";
            echo "    <td>" . $otsikko[2] . "</td>\n";
            echo "    <td>" . date("d.m.y H:i:s", strtotime(etsiViimeisinViesti($otsikko[3], $otsikko[1]))) . "</td>\n";
            echo "  </tr>\n";
        }
    }
}
echo "</table>\n";

?>
