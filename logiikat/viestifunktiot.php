<?php

function etsiViimeisinViesti($id, $uusin) {
    include("kyselyt.php");
    $palautus = $uusin;
    $vastaukset = select("id, aika", "Viesti", "vastaus = ('$id'");
    foreach ($vastaukset as $vastaus) {
        $palautus = max($palautus, etsiViimeisinViesti($vastaus["id"], $vastaus["aika"]));
    }
    return $palautus;
}

function etsiOnkoLukenut($kayttajanimi, $id) {
    $palautus = TRUE;
    $vastaukset = select("id, viestinlukeneet", "Viesti", "vastaus = ('$id'");
    $vastaukset = pg_query($yhteys, "SELECT id, viestinlukeneet FROM Viesti where vastaus = ('$id')");

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
    return $palautus;
}

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
