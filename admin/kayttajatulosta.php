<?php

if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {

    /*
     * Uuden käyttäjän luomislomake
     */
    function uusiKayttaja() {
        echo "<form name=\"Luo käyttäjä\" action=\"toiminnot/uusiKayttaja.php\" method=\"post\" >";
        echo "<table id=\"uusikayttajatable\">";
        echo "  <tr>";
        echo "    <td>Käyttäjänimi:</td>";
        echo "    <td><input type=\"text\" autofocus name=\"kayttajanimi\" maxlength=\"20\" pattern=\"^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$\" required placeholder=\"Käyttäjänimi\" /></td>";
        echo "  </tr>";
        echo "  <tr>";
        echo "    <td>Sähköposti:</td>";
        echo "    <td><input type=\"text\" name=\"sahkoposti\" placeholder=\"Sähköposti\" /></td>";
        echo "  </tr>";
        echo "    <td>Ylläpitäjä?</td>";
        echo "    <td><select name=\"admin\">";
        echo "          <option value=\"t\">Kyllä</option>";
        echo "          <option value=\"f\" selected>Ei</option>";
        echo "        </select></td>";
        echo "  </tr>";
        echo "  <tr>";
        echo "    <td>Salasana:</td>";
        echo "    <td><input class=\"salasana\" type=\"password\" name=\"salasana\" required placeholder=\"Salasana\" maxlength=\"20\"/></td>";
        echo "  </tr>";
        echo "    <td>Salasana uudelleen:</td>";
        echo "    <td><input class=\"salasana\" type=\"password\" name=\"salasana2\" required placeholder=\"Salasana\" maxlength=\"20\" oninput=\"tarkistasalasanat()\" /></td>";
        echo "  </tr>";
        echo "  <tr>";
        echo "  <tr>";
        echo "    <td><input type=\"submit\" /></td>";
        echo "  </tr>";
        echo "</table>";
        echo "</form>";
    }

    function tulostaKayttajat() {
        etsi();
        include_once 'logiikka/kayttajafunktiot.php';

        $kayttajat = getKayttajat();

        echo "<table>
           <tr>
             <th>Käyttäjänimi</th>
             <th>Sähköposti</th>
             <th>Ylläpitäjä</th>
             <th>Muokkaa</th>
             <th>Poista</th>
           </tr>";
        if (!empty($kayttajat)) {
            foreach ($kayttajat as $rivi) {
                echo "<tr>
             <td>" . $rivi["käyttäjänimi"] . "</td>
             <td>" . $rivi["sähköposti"] . "</td>
             <td>" . $rivi["ylläpitäjä"] . "</td>
             <td> <a href=\"admin.php?p=3&muokkaa=" . $rivi["käyttäjänimi"] . "\">x</a></td>
             <td> <a href=# onclick='varmista(\"toiminnot/poistaKayttaja.php?poista=" . $rivi["käyttäjänimi"] . "\", \"Oletko varma, että haluat poistaa käyttäjän?\")'>x</a></td>
           </tr>";
            }
        }
        echo "</table><br>";
    }

    function tulostaSamankaltaiset($nimi) {
        etsi();
        include_once 'logiikka/kayttajafunktiot.php';

        $kayttajat = getSamanlaiset($nimi);

        // Taulukon otsikko
        echo "<table>
           <tr>
             <th>Käyttäjänimi</th>
             <th>Sähköposti</th>
             <th>Ylläpitäjä</th>
             <th>Muokkaa</th>
             <th>Poista</th>
           </tr>";

        if (!empty($kayttajat)) {
            foreach ($kayttajat as $rivi) {
                echo "<tr>
             <td>" . $rivi["käyttäjänimi"] . "</td>
             <td>" . $rivi["sähköposti"] . "</td>
             <td>" . $rivi["ylläpitäjä"] . "</td>
             <td> <a href=\"admin.php?p=3&muokkaa=" . $rivi["käyttäjänimi"] . "\">x</a></td>";
                echo "</td>
             <td> <a href=# onclick='varmista(\"toiminnot/poistaKayttaja.php?poista=" . $rivi["käyttäjänimi"] . "\", \"Oletko varma, että haluat poistaa käyttäjän?\")'>x</a></td>
           </tr>";
            }
        }
        echo "</table><br>";
    }

    function avaaMuokkaus($nimi) {
        include_once 'logiikka/kayttajafunktiot.php';
        $kayttaja = getKayttaja($nimi);

        if (!empty($kayttaja)) {

            echo "<pre><form name=\"Muokkaa käyttäjää\" action=\"toiminnot/muokkaaKayttaja.php\" method=\"post\" >"
            . "Käyttäjänimi:	<input type=\"text\" name=\"käyttäjänimi\" autofocus value=\"" . $nimi . "\" pattern=\"^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$\" />\n"
            . "Sähköposti:	<input type=\"email\" name=\"sähköposti\" value=\"" . $kayttaja["sähköposti"] . "\" />\n"
            . "<input type=\"hidden\" name=\"vanhakäyttäjänimi\" value=\"" . $nimi . "\" />"
            . "Ylläpitäjä? 	<select name=\"admin\">"
            . "<option value=\"f\">Ei</option>"
            . "<option value=\"t\"";
            if ($kayttaja["ylläpitäjä"] == 't') {
                echo "selected";
            } echo ">Kyllä</option>"
            . "</select>\n"
            . "<input type=\"submit\" value=\"Vahvista\" /></form></pre>";
        } else {
            echo "<p class=\"virhe\">HEI!</p>";
        }
    }

    function etsi() {
        echo "Käyttäjänimi: <input type = \"text\" name = \"käyttäjänimi\" autofocus placeholder = \"Käyttäjänimi\" onkeypress=\"{if (event.keyCode==13)hae()}\"/>\n";
        echo "<button onclick=\"hae()\">Etsi!</button>\n";
        echo "<br/>";
        echo "<br/>";
    }

}
?>
