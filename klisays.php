<?php
  session_start();
  include("yhteys.php");
  $kysely = pg_prepare($yhteys, "lisays", 'INSERT INTO Käyttäjä (Käyttäjänimi, Sähköposti, Salasana, Ylläpitäjä) VALUES ($1, $2, $3, $4)');
  $kysely = pg_execute($yhteys, "lisays", array($_POST["kayttajanimi"], $_POST["sahkoposti"], $_POST["salasana"], $_POST["admin"]));
  header("Location: http://jeraiha.users.cs.helsinki.fi");
?>
