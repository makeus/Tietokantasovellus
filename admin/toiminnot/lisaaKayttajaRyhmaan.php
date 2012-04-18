<?php

session_start();
if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {
    include_once ("../../tietokanta/kyselyt.php");

    $ryhmannimi = escape($_POST["ryhmannimi"]);
    $jasen = escape($_POST["jasen"]);

    insert("RyhmäNimi(Ryhmännimi, RyhmänJäsen)", "'$ryhmannimi', '$jasen'");
    
    $ryhmat = select("id", "Ryhmä", "RyhmänNimi=('$ryhmannimi')");
    $ryhmanid = $ryhmat[0];
    $id = $ryhmanid["id"];

    header("Location: ../admin.php?p=1&m=$id");


}
?>
