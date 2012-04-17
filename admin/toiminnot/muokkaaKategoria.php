<?php

session_start();
if ((session_is_registered("käyttäjänimi")) and ($_SESSION["admin"] == 't')) {

    include_once ("../../tietokanta/kyselyt.php");

    $nimi = $_POST['nimi'];
    $nakyvyys = $_POST["nakyvyys"];
    $id = $_POST["id"];

    update("Kategoria", "KategorianNimi=('$nimi'), Näkyvyys=('$nakyvyys') WHERE Id=('$id')");
    header("Location: ../admin.php?p=5");
} else {
    header('HTTP/1.1 403 Forbidden');
}
?>
