<?php
  session_start();
  include("../yhteys.php");
  $ryhmat = pg_query($yhteys, 'SELECT Ryhmännimi FROM Ryhmä');
  $loytyy = FALSE;
  while ($rivi = pg_fetch_array($ryhmat)) {
    if($rivi[0] == $_POST["nimi"]) {
      $loytyy = TRUE;
    }
  }  
  $nimi = $_POST['nimi'];
  if($loytyy) {
    header("Location: admin.php?p=2&e=$nimi");
  } else {
    $kysely = pg_prepare($yhteys, "lisays", 'INSERT INTO Ryhmä (Ryhmännimi) VALUES ($1)');
    $kysely = pg_execute($yhteys, "lisays", array($_POST["nimi"]));
    $ryhmat = pg_query($yhteys, "SELECT id FROM Ryhmä where RyhmänNimi='$nimi'");
    $rivi = pg_fetch_array($ryhmat);
    header("Location: admin.php?p=1&m=$rivi[0]");
  }
?>
