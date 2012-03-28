<?php
  session_start();
  if($_SESSION["admin"] == 't'){
    include("../yhteys.php");
    $kysely = pg_prepare($yhteys, "lahetys", 'INSERT INTO RyhmäNimi (Ryhmännimi, RyhmänJäsen) VALUES ($1, $2)');
    $kysely = pg_execute($yhteys, "lahetys", array($_POST["ryhmannimi"], $_POST["jasen"]));
    header("Location: admin.php?p=1&m=2");
  } else {
    header('HTTP/1.1 403 Forbidden');
  }
?>
