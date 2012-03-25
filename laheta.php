<?php
  session_start();
  include("yhteys.php");
  $kysely = $yhteys->prepare("INSERT INTO Viesti (Aika, Teksti, Kirjoittaja) VALUES (NOW(), ?, ?)");
  $kysely->execute(array($_POST["viesti"], $_SESSION["käyttäjänimi"]));
  header("Location: http://keus.users.cs.helsinki.fi");
?>
