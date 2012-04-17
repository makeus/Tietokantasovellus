<?php
  session_start();
  if($_SESSION["admin"] == 't'){
    include("../yhteys.php");
    $kysely = pg_prepare($yhteys, "lahetys", 'DELETE FROM Kategoria WHERE id=($1)');
    $kysely = pg_execute($yhteys, "lahetys", array($_GET["id"]));
    header("Location: admin.php?p=5");
  } else {
    header('HTTP/1.1 403 Forbidden');
  }
?>
