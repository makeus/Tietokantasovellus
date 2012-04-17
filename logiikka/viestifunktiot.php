<?php

/*
 * Palauttaa viimeisimmän viestin ja/tai vastauksen ajan.
 */

function etsiViimeisinViesti($id, $uusin) {
    include_once 'kyselyt.php';
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
    include_once 'kyselyt.php';
    $palautus = TRUE;
    $vastaukset = select("id, viestinlukeneet", "Viesti", "vastaus = ('$id')");
    if (!empty($vastaukset)) {
        foreach ($vastaukset as $vastaus) {
            if (!in_array($kayttajanimi, pg_array_parse($vastaus["viestinlukeneet"], FALSE))) {
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
    include_once 'kyselyt.php';
    $vastaukset = select("*", "viesti", "kategoria=('$kid') and vastaus is null order by aika desc");
    return $vastaukset;
}

function getViesti($id) {
    include_once 'kyselyt.php';
    $vastaukset = select("*", "viesti", "id=('$id')");
    return $vastaukset[0];
}

function getVastaukset($id) {
    include_once 'kyselyt.php';
    $vastaukset = select("*", "viesti", "vastaus=('$id') ORDER BY Aika");
    return $vastaukset;
}

/*
 * Palauttaa id:n kuuluvan ryhmännimen.
 */

function getRyhmannimi($id) {
    include_once 'kyselyt.php';
    $ryhmat = select("RyhmänNimi", "Ryhmä", "id=('$id')");
    $ryhmannimi = $ryhmat[0];
    return $ryhmannimi["ryhmännimi"];
}

function merkkaaLuetuksi($id) {
    include("yhteys.php");
    $kayttajanimi = $_SESSION["käyttäjänimi"];
    $viesti = pg_query_params($yhteys, 'SELECT viestinlukeneet FROM Viesti WHERE Id= $1', array($id));
    $teksti = pg_fetch_array($viesti);

    if (!in_array($kayttajanimi, pg_array_parse($teksti[0], FALSE))) {
        $kysely = pg_prepare($yhteys, "append", 'UPDATE Viesti SET Viestinlukeneet = array_append(Viestinlukeneet, $1 :: text) where id= $2');
        $kysely = pg_execute($yhteys, "append", array($kayttajanimi, $id));
    }
}

/*
 * Tekee postgre muotosesta taulukosta php arrayn
 */

function pg_array_parse($array, $asText = true) {
    $s = $array;
    if ($asText) {
        $s = str_replace("{", "array('", $s);
        $s = str_replace("}", "')", $s);
        $s = str_replace(",", "','", $s);
    } else {
        $s = str_replace("{", "array(", $s);
        $s = str_replace("}", ")", $s);
    }
    $s = "\$retval = $s;";
    eval($s);
    return $retval;
}

?>