<?php
  session_start();
  include("yhteys.php");
  $kysely = pg_prepare($yhteys, "lahetys", 'DELETE FROM Viesti WHERE id=($1)');
  $kysely = pg_execute($yhteys, "lahetys", array($_GET["id"]));
  header("Location: http://keus.users.cs.helsinki.fi");
?>
