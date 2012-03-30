<?php

function tarkistaRyhmaNimi($nimi) {
  include("../yhteys.php");
  $ryhmat = pg_query($yhteys, 'SELECT Ryhmännimi FROM Ryhmä');
  $loytyy = FALSE;
  while ($rivi = pg_fetch_array($ryhmat)) {
    if($rivi[0] == $nimi) {
      $loytyy = TRUE;
    }
  }
  return $loytyy;
}

function tarkistaKategorianNimi($nimi) {
  include("../yhteys.php");
  $ryhmat = pg_query($yhteys, 'SELECT KategorianNimi FROM Kategoria');
  $loytyy = FALSE;
  while ($rivi = pg_fetch_array($ryhmat)) {
    if($rivi[0] == $nimi) {
      $loytyy = TRUE;
    }
  }
  return $loytyy;
}

function tarkistaKäyttäjä($nimi) {
  include("../yhteys.php");
  $ryhmat = pg_query($yhteys, 'SELECT Käyttäjänimi FROM Käyttäjä');
  $loytyy = FALSE;
  while ($rivi = pg_fetch_array($ryhmat)) {
    if($rivi[0] == $nimi) {
      $loytyy = TRUE;
    }
  }
  return $loytyy;
}


?>
