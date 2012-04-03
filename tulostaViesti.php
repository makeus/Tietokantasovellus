<?php
function tulostaViesti($viestin_id){
  session_start(); 
  echo "<div>";
  printtaaViesti($viestin_id);
  include("../yhteys.php");
  $viestit = pg_prepare($yhteys, "haku" ,'SELECT Id,Vastaus FROM Viesti WHERE Id= $1 order by aika');
  $viestit = pg_execute($yhteys, "haku", array($viestin_id));
  while ($rivi = pg_fetch_array($viestit)){
    tulostaViesti($rivi["Vastaus"]);
  }
  echo "</div>";
}
?>
