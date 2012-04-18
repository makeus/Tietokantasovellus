<?php

if (!session_is_registered("käyttäjänimi")) {
    header("HTTP/1.1 403 Forbidden");
} else {


    $GLOBALS['yhteys'] = pg_connect("dbname=keus user=keus password=a646a8dd503014f5");
    if ($GLOBALS['yhteys'] == FALSE) {
        echo "Tietokantayhteys epäonnistui!";
    }
}

function select($mita, $mista, $miten) {
    global $yhteys;
    $result = pg_query($GLOBALS['yhteys'], "SELECT $mita FROM $mista where $miten");
    $palautus = pg_fetch_all($result);
    return $palautus;
}

function selectorder($mita, $mista, $jarjestys) {
    $result = pg_query($GLOBALS['yhteys'], "SELECT $mita FROM $mista order by $jarjestys");
    $palautus = pg_fetch_all($result);
    return $palautus;
}

function delete($mista, $miten) {
    global $yhteys;
    $kysely = pg_query($GLOBALS['yhteys'], "DELETE FROM $mista WHERE $miten");
}

function update($mita, $miten) {
    global $yhteys;
    $kysely = pg_query($GLOBALS['yhteys'], "UPDATE $mita SET $miten");
}

function escape($string) {
    global $yhteys;
    $palautus = pg_escape_string($GLOBALS['yhteys'], htmlspecialchars($string));
    return $palautus;
}

function insert($minne, $mita) {
    global $yhteys;
    $kysely = pg_query($GLOBALS['yhteys'], "INSERT INTO $minne VALUES ($mita)");
}

?>
