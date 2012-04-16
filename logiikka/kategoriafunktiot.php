<?php

function getKategoriannimi($id) {
    include("kyselyt.php");
    $kategoriannimi = select1parametri("kategoriannimi", "kategoria", "id=('$kid')");
}

?>
