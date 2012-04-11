<?php
include("tarkista.php");

// Tarkistus, että käyttäjä saa katsoa viestin ja että viesti on olemassa
if(isset($_GET["id"])) {
  include("yhteys.php");
  $id = $_GET["id"];
  settype($id, "int");
  $viestit = pg_query_params($yhteys, 'SELECT Kategoria FROM Viesti WHERE Id= $1 ',array($id));
  $viesti = pg_fetch_row($viestit);
  if(($viesti != null) && in_array($viesti[0], $nakyvyys)) {
    tulostaViesti($id);
  }
  else {
    echo "<p id=\"eiviesteja\">HEI!</p>";
  }
} 
else {
  echo "<p id=\"eiviesteja\">HEI!</p>";
}

function tulostaViesti($viestin_id){
  merkkaaLuetuksi($viestin_id);
  printtaaViesti($viestin_id);
  echo "<form name=\"Vastaa viestiin\" action=\"vviesti.php\" method=\"post\" ><input type=\"hidden\" name=\"id\" value=\"".$viestin_id."\"  />";
  echo "<input name=\"vastaa\" type=\"submit\" value=\"Vastaa\" />";
  echo "</form>";
  include("yhteys.php");
  $viestit = pg_query_params($yhteys, 'SELECT Id FROM Viesti WHERE Vastaus= $1 ',array($viestin_id));
  while ($rivi = pg_fetch_array($viestit)){
    echo "<div class=\"viesti\">";
    tulostaViesti($rivi[0]);
    echo "</div>";
  }
  
}
function printtaaViesti($id){
  include("yhteys.php");
  $viesti = pg_query_params($yhteys,'SELECT Kirjoittaja,Aika,Teksti FROM Viesti WHERE Id= $1',array($id));
  $teksti = pg_fetch_array($viesti);
  echo "<p class=\"Kirjoittaja\">".$teksti[0]."(".$teksti[1].")</p>";
  echo "<p>".$teksti[2]."</p>";
}

function merkkaaLuetuksi($id) {
 include("yhteys.php");
 $kayttajanimi = $_SESSION["käyttäjänimi"];
 $kysely = pg_prepare($yhteys, "appendaa", 'UPDATE Viesti SET Viestinlukeneet = array_append(Viestinlukeneet, $1 :: text) where id= $2');
 $kysely = pg_execute($yhteys, "appendaa", array($kayttajanimi, $id));
}

?>
