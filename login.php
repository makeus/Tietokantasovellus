<?php
  session_start();
  include ("yhteys.php");
  $kayttajanimi = pg_escape_string($yhteys, htmlspecialchars($_POST["käyttäjänimi"]));
  $salasana = pg_escape_string($yhteys, htmlspecialchars($_POST["salasana"]));

  $kysely = pg_query($yhteys, "SELECT käyttäjänimi, ylläpitäjä FROM Käyttäjä WHERE Käyttäjänimi='". $kayttajanimi . "' and Salasana='". $salasana . "'");

  if (($tulos = pg_fetch_row($kysely)) != NULL) {
    $_SESSION["käyttäjänimi"] = $tulos[0];
    $_SESSION["admin"] = $tulos[1];
    header("Location: /");
  }
  else {
    header("Location: /?e=1");
  }
?>

