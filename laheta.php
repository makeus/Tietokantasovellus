<?php
  session_start();
  include("yhteys.php");
  $kysely = pg_prepare($yhteys, "lahetys", 'INSERT INTO Viesti (Aika, Otsikko, Teksti, Kirjoittaja, Kategoria) VALUES (NOW(), $1, $2, $3, $4)');
  $kysely = pg_execute($yhteys, "lahetys", array($_POST["otsikko"], $_POST["teksti"], $_SESSION["käyttäjänimi"], $_POST["kategoria"]));
  header("Location: http://keus.users.cs.helsinki.fi");
?>
