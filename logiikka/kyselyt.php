<?php

function select1parametri($mita, $mista, $miten) {
    include("yhteys.php");
    $result = pg_query($yhteys, "SELECT $mita FROM $mista where $miten");
    $palautus = pg_fetch_all($result);
}

?>
