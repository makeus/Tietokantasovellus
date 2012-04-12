<?php
include("tarkista.php");

// Tarkistus, että käyttäjä saa katsoa viestin ja että viesti on olemassa
if(isset($_GET["id"])) {
  include("yhteys.php");
  $id = $_GET["id"];
  settype($id, "int");
  $viestit = pg_query_params($yhteys, 'SELECT Kategoria, Otsikko FROM Viesti WHERE Id= $1 ',array($id));
  $viesti = pg_fetch_row($viestit);
  if(($viesti != null) && in_array($viesti[0], $nakyvyys)) {
    echo "<br/>";
    echo "<div id=\"viestijavastauksetlaatikko\">"; 
    echo "  <p class=\"kategoria\">" . $viesti[1] . "</p>";
    tulostaViesti($id);
    echo "</div>";
    include("kirjoitaViesti.php");
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
  
  include("yhteys.php");
  $viestit = pg_query_params($yhteys, 'SELECT Id FROM Viesti WHERE Vastaus= $1 ORDER BY Aika',array($viestin_id));
  while ($rivi = pg_fetch_array($viestit)){
    echo "<div class=\"viesti\">";
    tulostaViesti($rivi[0]);
    echo "</div>";
  }
  
}
function printtaaViesti($id){
  include("yhteys.php");
  $viesti = pg_query_params($yhteys,'SELECT Kirjoittaja,Aika,Teksti, Otsikko FROM Viesti WHERE Id= $1',array($id));
  $teksti = pg_fetch_array($viesti);
  echo "<p class=\"Kirjoittaja\">".$teksti[0]." (".date("d.m.y H:i:s", strtotime($teksti[1])).") " . $teksti[3] . "<a class=\"vastauslink\" href=\"/?p=2&v=" . $id . "\">vastaa</a></p>";
  echo "<p>".$teksti[2]."</p>";
}

function merkkaaLuetuksi($id) {
 include("yhteys.php");
 $kayttajanimi = $_SESSION["käyttäjänimi"];
 $viesti = pg_query_params($yhteys,'SELECT viestinlukeneet FROM Viesti WHERE Id= $1',array($id));
 $teksti = pg_fetch_array($viesti);

 if(!in_array($kayttajanimi, pg_array_parse($teksti[0], FALSE))) {
   $kysely = pg_prepare($yhteys, "append", 'UPDATE Viesti SET Viestinlukeneet = array_append(Viestinlukeneet, $1 :: text) where id= $2');
   $kysely = pg_execute($yhteys, "append", array($kayttajanimi, $id));
 }
}

function pg_array_parse($array, $asText = true) {
    $s = $array;
    if ($asText) {
        $s = str_replace("{", "array('", $s);
        $s = str_replace("}", "')", $s);    
        $s = str_replace(",", "','", $s);    
    } else {
        $s = str_replace("{", "array(", $s);
        $s = str_replace("}", ")", $s);
    }
    $s = "\$retval = $s;";
    eval($s);
    return $retval;
}

?>
