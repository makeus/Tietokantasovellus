<?php

/*
 * Poistaa kategorian
 */
session_start();
if ((session_is_registered("käyttäjänimi")) and ($_SESSION["admin"] == 't')) {
    include_once ("../../tietokanta/kyselyt.php");
    $id = $_GET["id"];
    settype($id, 'int');
    delete("Kategoria", "id=('$id')");
    header("Location: ../admin.php?p=5");
} else {
    header('HTTP/1.1 403 Forbidden');
}
?>
