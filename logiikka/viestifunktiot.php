<?php

if (!session_is_registered("käyttäjänimi")) {
    header("HTTP/1.1 403 Forbidden");
} else {

    /*
     * Palauttaa viimeisimmän viestin ja/tai vastauksen ajan.
     */

    function etsiViimeisinViesti($id, $uusin) {
        include_once 'tietokanta/kyselyt.php';
        $palautus = $uusin;
        $vastaukset = select("id, aika", "Viesti", "vastaus = ('$id')");
        if (!empty($vastaukset)) {
            foreach ($vastaukset as $vastaus) {
                $palautus = max($palautus, etsiViimeisinViesti($vastaus["id"], $vastaus["aika"]));
            }
        }
        return $palautus;
    }

    /*
     * Etsii onko parametrinä annettu käyttäjä lukenut parametrinä annetun id-viestin ja tämän vastaukset.
     * Palauttaa vastauksen boolean-tyyppisenä.
     */

    function etsiOnkoLukenut($kayttajanimi, $id) {
        include_once 'tietokanta/kyselyt.php';
        $palautus = TRUE;
        $vastaukset = select("id, viestinlukeneet", "Viesti", "vastaus = ('$id')");
        if (!empty($vastaukset)) {
            foreach ($vastaukset as $vastaus) {
                $taulu = array();
                pg_array_parse($vastaus["viestinlukeneet"], &$taulu, 1);
                if (!in_array($kayttajanimi, $taulu)) {
                    $palautus = FALSE;
                    break;
                } else {
                    if (!etsiOnkoLukenut($kayttajanimi, $vastaus["id"])) {
                        $palautus = FALSE;
                        break;
                    }
                }
            }
        }

        return $palautus;
    }

    /*
     * Hakee kategoriaan kuuluvat viestit
     * Otsikkojen tulostusta varten.
     */

    function getKategorianViestit($kid) {
        include_once 'tietokanta/kyselyt.php';
        $vastaukset = select("*", "viesti", "kategoria=('$kid') and vastaus is null order by aika desc");
        return $vastaukset;
    }

    /*
     * Hakee viestin id:n perusteella
     */

    function getViesti($id) {
        include_once 'tietokanta/kyselyt.php';
        $vastaukset = select("*", "viesti", "id=('$id')");
        return $vastaukset[0];
    }

    /*
     * Hakee id:n vastaukset
     */

    function getVastaukset($id) {
        include_once 'tietokanta/kyselyt.php';
        $vastaukset = select("*", "viesti", "vastaus=('$id') ORDER BY Aika");
        return $vastaukset;
    }

    /*
     * Palauttaa id:n kuuluvan ryhmännimen.
     */

    function getRyhmannimi($id) {
        include_once 'tietokanta/kyselyt.php';
        $ryhmat = select("RyhmänNimi", "Ryhmä", "id=('$id')");
        $ryhmannimi = $ryhmat[0];
        return $ryhmannimi["ryhmännimi"];
    }

    /*
     * Merkkaa id:n viestin luetuksi
     */

    function merkkaaLuetuksi($id, $kayttajanimi) {
        include_once 'tietokanta/kyselyt.php';
        $viesti = getViesti($id);
        $taulu = array();
        pg_array_parse($viesti["viestinlukeneet"], &$taulu, 1);
        if (!in_array($kayttajanimi, $taulu)) {
            update("Viesti", "Viestinlukeneet = array_append(Viestinlukeneet, ('$kayttajanimi') :: text) where id='$id'");
        }
    }

    /*
     * Tekee postgre muotosesta taulukosta php arrayn
     */

    function pg_array_parse($text, &$output, $limit = false, $offset = 1) {
        if (false === $limit) {
            $limit = strlen($text) - 1;
            $output = array();
        }
        if ('{}' != $text)
            do {
                if ('{' != $text{$offset}) {
                    preg_match("/(\\{?\"([^\"\\\\]|\\\\.)*\"|[^,{}]+)+([,}]+)/", $text, $match, 0, $offset);
                    $offset += strlen($match[0]);
                    $output[] = ( '"' != $match[1]{0} ? $match[1] : stripcslashes(substr($match[1], 1, -1)) );
                    if ('},' == $match[3])
                        return $offset;
                }
                else
                    $offset = pg_array_parse($text, $output[], $limit, $offset + 1);
            }
            while ($limit > $offset);
        return $output;
    }

}
?>
