<?php
  session_start();
  include ("yhteys.php");
  $kysely = pg_query($yhteys, "SELECT käyttäjänimi, ylläpitäjä FROM Käyttäjä WHERE Käyttäjänimi='". $_POST["käyttäjänimi"]. "' and Salasana='". $_POST["salasana"]."'");
  if (($tulos = pg_fetch_row($kysely)) != NULL) {
    $_SESSION["käyttäjänimi"] = $tulos[0];
    $_SESSION["admin"] = $tulos[1];
    header("Location: http://keus.users.cs.helsinki.fi");
  }
  else {
    echo "Väärä käyttäjänimi tai salasana!";
  }
?>

