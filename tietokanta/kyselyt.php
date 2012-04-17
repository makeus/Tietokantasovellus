<?php

if (!session_is_registered("käyttäjänimi")) {
    header("HTTP/1.1 403 Forbidden");
} else {

    function select($mita, $mista, $miten) {
        include 'yhteys.php';
        $result = pg_query($yhteys, "SELECT $mita FROM $mista where $miten");
        $palautus = pg_fetch_all($result);
        return $palautus;
    }

    function selectorder($mita, $mista, $jarjestys) {
        include 'yhteys.php';
        $result = pg_query($yhteys, "SELECT $mita FROM $mista order by $jarjestys");
        $palautus = pg_fetch_all($result);
        return $palautus;
    }

    function delete($mista, $miten) {
        include 'yhteys.php';
        $kysely = pg_query($yhteys, "DELETE FROM $mista WHERE $miten");
    }

    function update($mita, $miten) {
        include 'yhteys.php';
        $kysely = pg_query($yhteys, "UPDATE $mita SET $miten");
    }

    function escape($string) {
        include 'yhteys.php';
        $palautus = pg_escape_string($yhteys, htmlspecialchars($string));
        return $palautus;
    }

    function insert($minne, $mita) {
        include 'yhteys.php';
        $kysely = pg_query($yhteys, "INSERT INTO $minne VALUES ($mita)");
    }

}
?>
