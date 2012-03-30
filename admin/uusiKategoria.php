<?php
  session_start();
  include("../yhteys.php");
  $kysely = pg_prepare($yhteys, "lisays", 'INSERT INTO Kategoria (Kategoriannimi, Näkyvyys) VALUES ($1, $2)');
  $kysely = pg_execute($yhteys, "lisays", array($_POST["nimi"], $_POST["nakyvyys"]));
  header("Location: admin.php?p=5");
?>
