<?php
function tulostaViesti($viestin_id){
  session_start(); 
  echo "<div class=\"viesti\">";
  printtaaViesti($viestin_id);
  echo "<form name=\"Vastaa viestiin\" action=\"vviesti.php\" method=\"post\" ><input type=\"hidden\" name=\"id\" value=\"".$viestin_id."\"  />";
  echo "<input name=\"vastaa\" type=\"submit\" value=\"Vastaa\" />";
  include("yhteys.php");
  $viestit = pg_query_params($yhteys, 'SELECT Id FROM Viesti WHERE Vastaus= $1 order by aika',array($viestin_id));
  while ($rivi = pg_fetch_array($viestit)){
    tulostaViesti($rivi[0]);
  }
  echo "</div>";
}
function printtaaViesti($id){
  include("yhteys.php");
  $viesti = pg_query_params($yhteys,'SELECT Teksti FROM Viesti WHERE Id= $1',array($id));
  $teksti = pg_fetch_array($viesti);
  echo "<p>".$teksti[0]."</p>";
}
function merkkaaLuetuksi($id) {
 $kayttajanimi = $_SESSION["käyttäjänimi"];
 $kysely = pg_prepare($yhteys, "lisays", "UPDATE Viesti SET Viestinlukeneet= Viestinlukeneet || ('$1') where id=('$2')");
 $kysely = pg_execute($yhteys, "lisays", array($kayttajanimi, id));
}
?>
