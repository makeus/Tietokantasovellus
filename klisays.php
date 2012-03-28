<?php
  session_start();
  include("yhteys.php");
  $kysely = pg_prepare($yhteys, "lisays", 'INSERT INTO Käyttäjä (Käyttäjänimi, Sähköposti, Salasana, ylläpitäjä) VALUES (NOW(), $1, $2, $3, $4)');
  $kysely = pg_execute($yhteys, "lisays", array($_POST["knimi"], $_POST["sposti"], $_SESSION["ssana"], $_POST["admin"]));
  header("Location: http://jeraiha.users.cs.helsinki.fi");
?>
