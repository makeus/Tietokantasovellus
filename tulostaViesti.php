<?php

include_once("logiikka/kategoriafunktiot.php");
include_once("logiikka/viestifunktiot.php");

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
  if($_SESSION["admin"] == 't' || $teksti[0]==$_SESSION["käyttäjänimi"]){
  echo "<p class=\"Kirjoittaja\">".$teksti[0].
    " (".date("d.m.y H:i:s", strtotime($teksti[1])).") " 
    . $teksti[3] .
    "<a class=\"poistolink\" href=# onclick='varmista(\"poista.php?id=" . $id . "\", \"Oletko varma, että haluat poistaa viestin?\")'>poista</a>"
    ."<a class=\"vastauslink\" href=\"/?p=2&v=" . $id . "\">vastaa</a></p>";
  echo "<p>".$teksti[2]."</p>";
  }else{
    echo "<p class=\"Kirjoittaja\">".$teksti[0].
    " (".date("d.m.y H:i:s", strtotime($teksti[1])).") " 
    . $teksti[3] .
    "<a class=\"vastauslink\" href=\"/?p=2&v=" . $id . "\">vastaa</a></p>";
  echo "<p>".$teksti[2]."</p>";
  }
}

/*
 * Tarkistetaan, että käyttäjä saa katsoa viestin ja tulostetaan viesti.
 */
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    settype($id, 'int');
    $viesti = getViesti($id);
    if ((!empty($viesti)) && (in_array($viesti["kategoria"], $nakyvyys))) {
        echo "<br/>";
        echo "<div id=\"viestijavastauksetlaatikko\">";
        echo "  <p class=\"kategoria\">" . $viesti["otsikko"] . "</p>";
        tulostaViesti($id);
        echo "</div>";
        include_once 'kirjoitaViesti.php';
    } else {
        echo "<p id=\"eiviesteja\">HEI!</p>";
    }
} else {
    echo "<p id=\"eiviesteja\">HEI!</p>";
}

/*
 * Merkataan viesti luetuksi, tulostetaan viesti ja kutsutaan rekursiivisesti kaikille vastauksille.
 */

function tulostaViesti($viestin_id) {
    merkkaaLuetuksi($viestin_id);
    printtaaViesti($viestin_id);
    $viestit = getVastaukset($viestin_id);
    if (!empty($viestit)) {
        foreach ($viestit as $rivi) {
            echo "<div class=\"viesti\">";
            tulostaViesti($rivi["id"]);
            echo "</div>";
        }
    }
}

function printtaaViesti($id) {
    $viesti = getViesti($id);
    echo "<p class=\"Kirjoittaja\">" . $viesti["kirjoittaja"] . " (" . date("d.m.y H:i:s", strtotime($viesti["aika"])) . ") " . $viesti["otsikko"] . "<a class=\"vastauslink\" href=\"/?p=2&v=" . $id . "\">vastaa</a></p>";
    echo "<p>" . $viesti["teksti"] . "</p>";
}

?>
