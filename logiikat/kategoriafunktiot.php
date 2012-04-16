<?php

function getKategoriannimi($id) {
    include("kyselyt.php");
    $kategoriat = select("kategoriannimi", "kategoria", "id=('$id')");
    var_dump($kategoriat);
    $kategoriannimi = $kategoriat[0];
    return $kategoriannimi["kategoriannimi"];
}

?>
