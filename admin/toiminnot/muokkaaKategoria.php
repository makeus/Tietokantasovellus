<?php

/*
 * Muokkaa kategorian tietoja
 */
session_start();
if ((session_is_registered("käyttäjänimi")) and ($_SESSION["admin"] == 't')) {

    include_once ("../../tietokanta/kyselyt.php");

    $nimi = escape($_POST['nimi']);
    $nakyvyys = escape($_POST["nakyvyys"]);
    $id = $_POST["id"];
    settype($id, 'int');

    update("Kategoria", "KategorianNimi=('$nimi'), Näkyvyys=('$nakyvyys') WHERE Id=('$id')");
    header("Location: ../admin.php?p=5");
} else {
    header('HTTP/1.1 403 Forbidden');
}
?>
