<?php



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

?>