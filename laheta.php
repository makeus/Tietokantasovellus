<?php
  include("yhteys.php");
  $kysely = $yhteys->prepare("INSERT INTO teksti (viesti) VALUES (?)");
  $kysely->execute(array($_POST["viesti"]));
  header("Location: http://keus.users.cs.helsinki.fi");
?>
