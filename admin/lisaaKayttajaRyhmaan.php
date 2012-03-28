<?php
  session_start();
  if($_SESSION["admin"] == 't'){
    include("../yhteys.php");
    $kysely = pg_prepare($yhteys, "lahetys", 'INSERT INTO RyhmäNimi (Ryhmännimi, RyhmänJäsen) VALUES ($1, $2)');
    $kysely = pg_execute($yhteys, "lahetys", array($_POST["ryhmannimi"], $_POST["jasen"]));
    $ryhmanimi = $_POST["ryhmannimi"];
    $ryhmat = pg_query($yhteys, "SELECT id FROM Ryhmä where ryhmännimi=('$ryhmanimi')");
    $rivi = pg_fetch_row($ryhmat);
    header("Location: admin/admin.php?p=1&m=$rivi[0]");
  } else {
    header('HTTP/1.1 403 Forbidden');
  }
?>
