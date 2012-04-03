<?php
function tulostaViesti($viestin_id){
  session_start(); 
  echo "<div>";
  printtaaViesti($viestin_id);
  include("yhteys.php");
  $viestit = pg_prepare($yhteys, "haku" ,'SELECT Id FROM Viesti WHERE Vastaus= $1 order by aika');
  $viestit = pg_execute($yhteys, "haku", array($viestin_id));
  while ($rivi = pg_fetch_array($viestit)){
    tulostaViesti($rivi["Id"]);
  }
  echo "</div>";
}
function printtaaViesti($id){
  include("yhteys.php");
  $viesti = pg_prepare($yhteys, "haku" ,'SELECT Teksti FROM Viesti WHERE Id= $1');
  $viesti = pg_execute($yhteys, "haku", array($id));
  $rivi = pg_fetch_array($viesti);
  echo "".$rivi["Teksti"]."";
}
function merkkaaLuetuksi($id) {
 $kayttajanimi = $_SESSION["käyttäjänimi"];
 $kysely = pg_prepare($yhteys, "lisays", "UPDATE Viesti SET Viestinlukeneet= Viestinlukeneet || ('$1') where id=('$2')");
 $kysely = pg_execute($yhteys, "lisays", array($kayttajanimi, id));
}
?>
