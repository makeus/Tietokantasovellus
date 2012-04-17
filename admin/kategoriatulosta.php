<?php

if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {

    function tulostaKategoriat() {


        include_once 'logiikka/kategoriafunktiot.php';
        include_once 'logiikka/ryhmafunktiot.php';

        $kategoriat = getKategoriat();

        // Taulukon otsikko
        echo "<table>
           <tr>
             <th>ID</th>
             <th>Kategorian nimi</th>
             <th>Näkyvyys</th>
             <th>Muokkaa</th>
             <th>Poista</th>
           </tr>";

        if (!empty($kategoriat)) {
            foreach ($kategoriat as $rivi) {
                $nakyvyys = $rivi["näkyvyys"];
                $ryhmannimi = getRyhmannimi($nakyvyys);

                echo "<tr>
                        <td>" . $rivi["id"] . "</td>
                        <td>" . $rivi["kategoriannimi"] . "</td>
                        <td>" . $ryhmannimi . "</td>
                        <td> <a href=\"admin.php?p=5&m=" . $rivi["id"] . "\">x</a></td>";
                echo "</td>
                        <td> <a href=# onclick='varmista(\"toiminnot/poistaKategoria.php?id=" . $rivi["id"] . "\", \"Oletko varma, että haluat poistaa kategorian? Poistaminen poistaa myös kategoriaan kuuluvat viestit\")'>x</a></td>
                     </tr>";
            }
        }
        echo "</table><br>";
    }

    function muokkaaKategoria($id) {
        include_once 'logiikka/kategoriafunktiot.php';
        include_once 'logiikka/ryhmafunktiot.php';


        $kategoria = getKategoria($id);

        if (empty($kategoria)) {
            header("Location: admin.php?p=5");
        } else {


            $kategoriannimi = $kategoria["kategoriannimi"];
            $ryhmat = getRyhmat();

            echo "<h2>Muokkaa kategoriaa " . $kategoriannimi . "</h2>\n";
            echo "<form method=\"post\" action=\"toiminnot/muokkaaKategoria.php\">\n";
            echo "<input type=\"hidden\" name=\"id\" maxlenght=\"100\" value=\"" . $kategoria["id"] . "\"/>";
            echo "<pre>Kategorian nimi:	<input type=\"text\" name=\"nimi\" value=\"" . $kategoriannimi . "\" required />\n";
            echo "Näkyvyys:		<select name=\"nakyvyys\">\n";

            foreach ($ryhmat as $ryhmarivi) {
                echo "<option value=\"" . $ryhmarivi["id"] . "\"";

                if ($ryhmarivi["id"] == $kategoria["näkyvyys"]) {
                    echo " selected";
                }
                echo " />" . $ryhmarivi["ryhmännimi"] . "</option>\n";
            }

            echo "</select>\n";
            echo "<input type=\"submit\" value=\"Vahvista\" />\n";
            echo "</pre>\n</form>";
        }
    }

    function uusiKategoria() {

        include_once 'logiikka/ryhmafunktiot.php';

        $ryhmat = getRyhmat();

        if (empty($ryhmat)) {
            echo "<p class=\"virhe\"> EI RYHMIÄ!</p>";
        } else {

            echo "<pre><form method=\"post\" action=\"toiminnot/uusiKategoria.php\">";
            echo "Kategorian nimi:	<input id=\"kategoriannimi\" type=\"text\" autofocus name=\"nimi\" placeholder=\"Kategorian nimi\" required maxlength=\"50\">\n";
            echo "Näkyvyys:		<select name=\"nakyvyys\">\n";

            foreach ($ryhmat as $ryhmarivi) {
                echo "<option value=\"" . $ryhmarivi["id"] . "\"";
                echo " />" . $ryhmarivi["ryhmännimi"] . "</option>\n";
            }
            echo "</select>\n";
            echo "<input type=\"submit\">";
            echo "</form></pre>";
        }
    }

}
?>
