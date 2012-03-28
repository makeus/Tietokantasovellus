<?php
  function tulostaRyhmat(){
   session_start(); 
   
   if($_SESSION["admin"] == 't'){


    // "valmistellaan" molemmat haut, ja haetaan ryhmät
    include("../yhteys.php");
    $ryhmat = pg_query($yhteys, 'SELECT * FROM Ryhmä');
    $jasenet = pg_prepare($yhteys, "jasenet", 'SELECT Ryhmänjäsen FROM RyhmäNimi WHERE ryhmännimi=$1');

    // Taulukon otsikko
    echo "<table>
           <tr>
             <th>ID</th>
             <th>Ryhmän nimi</th>
             <th>Ryhmän jäsenet</th>
             <th>Muokkaa</th>
             <th>Poista</th>
           </tr>";    

    // Haetaan kaikki ryhmät
    while ($rivi = pg_fetch_array($ryhmat)) {
     echo "<tr>
             <td>" . $rivi["id"] . "</td>
             <td>" . $rivi["ryhmännimi"] . "</td>
             <td>";
     $jasenet = pg_execute($yhteys, "jasenet", array($rivi["ryhmännimi"])); 
     
    // Haetaan nykysen ryhmän kaikki jäsenet
     while($jasen = pg_fetch_array($jasenet)) {
       echo $jasen["ryhmänjäsen"] . ", ";
     }
     echo "</td>
             <td> <a href=# >x</a></td>";
     echo "</td>
             <td> <a href=# onclick='varmista(\"poistaRyhma.php?id=" . $rivi["id"] . "\")'>x</a></td>
           </tr>";

    }
    echo "</table><br><br>";
  }
  else { 
    header('HTTP/1.1 403 Forbidden');
  }
}

function muokkaaRyhma($id) {
    include("../yhteys.php");
    $ryhmat = pg_query($yhteys, "SELECT ryhmännimi FROM Ryhmä where id=('$id')");
    $rivi = pg_fetch_row($ryhmat);
    $ryhmannimi = $rivi[0];
    $jasenet = pg_query($yhteys, "SELECT ryhmänjäsen FROM RyhmäNimi where Ryhmännimi=('$ryhmannimi')");

    echo "<form method=\"post\" action=\"poistaKayttajaRyhmasta.php\">";    
    echo "<select size=\"" . pg_num_rows($jasenet) . "\" name=\"jasenet\">";
  
    $kayttajat = array(); // Taulukko ryhmän käyttäjistä

    while($jasen = pg_fetch_array($jasenet)) {
       echo "<option value=\"" . $jasen["ryhmänjäsen"] . "\">" . $jasen["ryhmänjäsen"] . "</option>";
       array_push($kayttajat, $jasen["ryhmänjäsen"]); // Lisätään ryhmän taulukkoon jäsen
    }
    echo "</select>";
    echo "<input type=\"submit\" value=\">\" />";
    echo "</form>";
    
    // Tehdää String taulukon alkioista kyselyä varten
    $maar = "";    
    foreach($kayttajat as $alkio) {
      $maar = $maar . " and Käyttäjänimi != '" . $alkio . "'";
    }

    // Haetaan kaikki paitsi ryhmän jäsenet
    $toiset = pg_query($yhteys, "SELECT käyttäjänimi FROM Käyttäjä where Käyttäjänimi!=('$kayttajat[0]')$maar");
     
    echo "<form method=\"post\" action=\"lisaaKayttajaRyhmaan.php\">";  
    echo "<input type=\"submit\" value=\"<\" />";
    echo "<select size=\"" . pg_num_rows($jasenet) . "\" name=\"jasenet\">";
   
    while($jasen = pg_fetch_array($toiset)) {
       echo "<option value=\"" . $jasen["käyttäjänimi"] . "\">" . $jasen["käyttäjänimi"] . "</option>";
    }
    echo "</select>";

    echo "</form>";
}



?>
