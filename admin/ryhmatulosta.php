<?php

if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {

    function tulostaRyhmat() {

        include_once 'logiikka/ryhmafunktiot.php';
        $ryhmat = getRyhmat();

        // Taulukon otsikko
        echo "<table>
           <tr>
             <th>ID</th>
             <th>Ryhmän nimi</th>
             <th>Ryhmän jäsenet</th>
             <th>Muokkaa</th>
             <th>Poista</th>
           </tr>";

        // Haetaan kaikki ryhmät
        if (!empty($ryhmat)) {
            foreach ($ryhmat as $rivi) {
                echo "<tr>
             <td>" . $rivi["id"] . "</td>
             <td>" . $rivi["ryhmännimi"] . "</td>
             <td>";

                // Haetaan nykysen ryhmän kaikki jäsenet
                $jasenet = getRyhmanJasenet($rivi["ryhmännimi"]);
                if (!empty($jasenet)) {
                    foreach ($jasenet as $jasen) {
                        echo $jasen["ryhmänjäsen"] . ", ";
                    }
                }
                echo "</td>
             <td> <a href=\"admin.php?p=1&m=" . $rivi["id"] . "\">x</a></td>";
                echo "  <td> <a href=# onclick='varmista(\"toiminnot/poistaRyhma.php?id=" . $rivi["id"] . "\", \"Oletko varma, että haluat poistaa ryhmän? Poistaminen poistaa myös kategorian, viestit..\")'>x</a></td>
           </tr>";
            }
        }
        echo "</table><br>";
    }

    function muokkaaRyhma($id) {
        include_once 'logiikka/ryhmafunktiot.php';
        $ryhmannimi = getRyhmannimi($id);
        if (!isset($ryhmannimi)) {
            header("Location: admin.php?p=1");
        }
        $jasenet = getRyhmanJasenet($ryhmannimi);


        echo "<h2 class=\"ryhmah2\">Ryhmän " . $ryhmannimi . " käyttäjät</h2><h2 class=\"ryhmah2\">Muut käyttäjät</h2>";
        echo "<form class=\"ryhmaform\" method=\"post\" action=\"toiminnot/poistaKayttajaRyhmasta.php\">";
        echo "<input type=\"hidden\" value=\"" . $ryhmannimi . "\" name=\"ryhmannimi\">";
        echo "<select class=\"ryhmaselect\" size=\"4\" name=\"jasen\">";

        $kayttajat = array(); // Taulukko ryhmän käyttäjistä

        if (!empty($jasenet)) {
            foreach ($jasenet as $jasen) {
                echo "<option value=\"" . $jasen["ryhmänjäsen"] . "\">" . $jasen["ryhmänjäsen"] . "</option>";
                array_push($kayttajat, $jasen["ryhmänjäsen"]); // Lisätään ryhmän taulukkoon jäsen
            }
        }
        echo "</select>";
        echo "<input class=\"isosubmit\" type=\"submit\" value=\">\" />";
        echo "</form>";

        // Tehdää String taulukon alkioista kyselyä varten
        $maar = "";
        if (!empty($kayttajat)) {
            foreach ($kayttajat as $alkio) {
                $maar = $maar . " and Käyttäjänimi != '" . $alkio . "'";
            }
            // Haetaan kaikki paitsi ryhmän jäsenet
            $ekakayttaja = $kayttajat[0];
            $toiset = getKayttajat("Käyttäjänimi!=('$ekakayttaja')$maar");
        } else {
            $toiset = getKayttajatAll();
        }
        echo "<form class=\"ryhmaform\" method=\"post\" action=\"toiminnot/lisaaKayttajaRyhmaan.php\">";
        echo "<input type=\"hidden\" value=\"" . $ryhmannimi . "\" name=\"ryhmannimi\">";
        echo "<input class=\"isosubmit\" type=\"submit\" value=\"<\" />";

        echo "<select class=\"ryhmaselect\" size=\"4\" name=\"jasen\">";

        if (!empty($toiset)) {
            foreach ($toiset as $jasen) {
                echo "<option value=\"" . $jasen["käyttäjänimi"] . "\">" . $jasen["käyttäjänimi"] . "</option>";
            }
        }
        echo "</select>";
        echo "</form>";
    }

    function uusiRyhma() {
        echo "<pre><form method=\"post\" action=\"toiminnot/uusiRyhma.php\">";
        echo "Ryhmän nimi:	<input type=\"text\" name=\"nimi\" autofocus placeholder=\"Ryhmän nimi\" maxlength=\"19\" required>\n";
        echo "<input type=\"submit\">";
        echo "</form></pre>";
    }

}
?>
