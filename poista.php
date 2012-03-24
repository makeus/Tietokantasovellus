<?php
  include("yhteys.php");
  $kysely = $yhteys->prepare("DELETE FROM teksti WHERE viesti=(?)");
  $kysely->execute(array($_GET["viesti"]));
  header("Location: http://keus.users.cs.helsinki.fi");
?>
