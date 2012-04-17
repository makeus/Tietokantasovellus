<?php

session_start();
if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {
    include_once ("../../tietokanta/kyselyt.php");
    $id = $_GET["id"];
    settype($id, 'int');
    delete("Ryhmä", "id=('$id')");
    header("Location: ../admin.php?p=1");
}
?>
