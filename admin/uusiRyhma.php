<?php
  session_start();
  include("../yhteys.php");
  include("tarkistukset.php");
  $nimi = $_POST['nimi'];
  if(tarkistaRyhmaNimi($nimi)) {
    header("Location: admin.php?p=2&e=$nimi");
  } else {
    $kysely = pg_prepare($yhteys, "lisays", 'INSERT INTO Ryhmä (Ryhmännimi) VALUES ($1)');
    $kysely = pg_execute($yhteys, "lisays", array($_POST["nimi"]));
    $ryhmat = pg_query($yhteys, "SELECT id FROM Ryhmä where RyhmänNimi='$nimi'");
    $rivi = pg_fetch_array($ryhmat);
    $id = $rivi[0];
    header("Location: admin.php?p=1&m=$id");
  }
?>
