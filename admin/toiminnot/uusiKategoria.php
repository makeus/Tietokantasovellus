<?php

/*
 * Lisää uuden kategorian
 */
session_start();
if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {
    include_once ("../../tietokanta/kyselyt.php");

    $nimi = $_POST["nimi"];
    $nimi = escape($nimi);
    $nakyvyys = $_POST["nakyvyys"];
    settype($nakyvyys, 'int');

    insert("Kategoria(KategorianNimi, Näkyvyys)", "'$nimi', '$nakyvyys'");

    header("Location: ../admin.php?p=5");
}
?>
