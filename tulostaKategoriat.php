<?php

if (!session_is_registered("käyttäjänimi")) {
    header("HTTP/1.1 403 Forbidden");
} else {

    /*
     * Etusivun kategorioiden ja niihin kuuluvien otsikoiden tulostus
     */

    include_once("logiikka/kategoriafunktiot.php");
    include_once("logiikka/viestifunktiot.php");

    /*
     * Haetaan käyttäjälle sallitut kategoriat ja valmistellaan taulukko.
     * Jos ei viestejä, virheilmoitus.
     */
    $kayttajanimi = $_SESSION["käyttäjänimi"];
    $nakyvyys = getNakyvyys($kayttajanimi);

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

    /*
     * Toistetaan jokaiselle käyttäjän kategorialle.
     */
    foreach ($nakyvyys as $kid) {
        $kategorianimi = getKategoriannimi($kid);
        $otsikot = getKategorianViestit($kid);

        /*
         * Tarkistetaan onko kategoriassa viestejä.
         * Tyhjiä kategorioita ei näytetä.
         */
        if (!empty($otsikot)) {
            echo "  <tr>\n";
            echo "    <td colspan=\"3\" class=\"kategoria\">" . $kategorianimi . "</td>\n";
            echo "  </tr>\n";
            echo "  <tr class=\"otsikko\">\n";

            foreach ($otsikot as $otsikko) {
                echo "  <tr class=\"otsikko\">\n";

                /*
                 * Tarkistetaan onko käyttäjä lukenut kyseisen otsikon kaikki viestit. 
                 */
                $taulu = array();
                pg_array_parse($otsikko["viestinlukeneet"], &$taulu, 1);
                if (($otsikko["viestinlukeneet"] != null) && (in_array($kayttajanimi, &$taulu)) && etsiOnkoLukenut($kayttajanimi, $otsikko["id"])) {
                    echo "    <td>";
                } else {
                    echo "    <td class=\"lukematon\">";
                }

                /*
                 * Tulostetaan otsikko, kirjoittaja, sekä uusimman vastauksen/viestin aika 
                 */
                echo "<a href=\"/?p=3&id=" . $otsikko["id"] . "\">" . $otsikko["otsikko"] . "</a>\n";
                echo "    </td>\n";
                echo "    <td>" . $otsikko["kirjoittaja"] . "</td>\n";
                echo "    <td>" . date("d.m.y H:i:s", strtotime(etsiViimeisinViesti($otsikko["id"], $otsikko["aika"]))) . "</td>\n";
                echo "  </tr>\n";
            }
        }
    }
    echo "</table>\n";
}
?>
