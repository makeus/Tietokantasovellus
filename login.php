<?php
  session_start();
  include ("yhteys.php");
  $haku = $yhteys->prepare("SELECT käyttäjänimi FROM Käyttäjä WHERE Käyttäjänimi='". $_POST["käyttäjänimi"]. "' and Salasana='". $_POST["salasana"]."'");
  $haku -> execute();

  if (count($haku -> fetch()) == 2) {
    $_SESSION["käyttäjänimi"] = $_POST["käyttäjänimi"];
    header("Location: http://keus.users.cs.helsinki.fi");
  }
  else {
    echo "Väärä käyttäjänimi tai salasana!";
  }
?>

