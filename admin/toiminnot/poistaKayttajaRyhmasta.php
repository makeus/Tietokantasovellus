<?php

session_start();
if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {
    include_once ("../../tietokanta/kyselyt.php");

    $ryhmannimi = $_POST["ryhmannimi"];
    $jasen = $_POST["jasen"];

    delete("RyhmäNimi", "ryhmännimi=('$ryhmannimi') and ryhmänjäsen=('$jasen')");
    
    $ryhmat = select("id", "Ryhmä", "RyhmänNimi=('$ryhmannimi')");
    $ryhmanid = $ryhmat[0];
    $id = $ryhmanid["id"];

    header("Location: ../admin.php?p=1&m=$id");
}
?>
