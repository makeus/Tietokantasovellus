<?php
  include("yhteys.php");
  $kysely = $yhteys->prepare("DELETE FROM Viesti WHERE id=(?)");
  $kysely->execute(array($_GET["id"]));
  header("Location: http://keus.users.cs.helsinki.fi");
?>
