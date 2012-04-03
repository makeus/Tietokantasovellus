<?php
function tulostaViesti($viestin_id){
  session_start(); 
  echo "<div>";
  printtaaViesti($viestin_id);
  include("yhteys.php");
  $viestit = pg_prepare($yhteys, "viestit" ,'SELECT Id FROM Viesti WHERE Vastaus= $1 order by aika');
  $viestit = pg_execute($yhteys, "viestit", array($viestin_id));
  while ($rivi = pg_fetch_array($viestit)){
    tulostaViesti($rivi["Id"]);
  }
  echo "</div>";
}
function printtaaViesti($id){
  include("yhteys.php");
  $viesti = pg_prepare($yhteys, "viesti" ,'SELECT Teksti FROM Viesti WHERE Id= $1');
  $viesti = pg_execute($yhteys, "viesti", array($id));
  echo "".$viesti."";
}
function merkkaaLuetuksi($id) {
 $kayttajanimi = $_SESSION["käyttäjänimi"];
 $kysely = pg_prepare($yhteys, "lisays", "UPDATE Viesti SET Viestinlukeneet= Viestinlukeneet || ('$1') where id=('$2')");
 $kysely = pg_execute($yhteys, "lisays", array($kayttajanimi, id));
}
?>
