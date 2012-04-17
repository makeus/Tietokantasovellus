<?php

if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {

    function getKategoriat() {
        include_once '../tietokanta/kyselyt.php';
        $kategoriat = selectorder("*", "Kategoria", "id");
        return $kategoriat;
    }
    
    function getKategoria($id) {
        include_once '../tietokanta/kyselyt.php';
        $kategoriat = select("*", "Kategoria", "id=('$id')");
        return $kategoriat[0];
    }
    
    

}
?>
