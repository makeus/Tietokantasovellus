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
             <td> <a href=\"admin.php?p=1&m=" . $rivi["id"] ."\">x</a></td>";
     echo "  <td> <a href=# onclick='varmista(\"poistaRyhma.php?id=" . $rivi["id"] . "\", \"Oletko varma, että haluat poistaa ryhmän? Poistaminen poistaa myös kategorian, viestit..\")'>x</a></td>
           </tr>";

    }
    echo "</table><br>";
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
    if(!isset($ryhmannimi)){
      header("Location: admin.php?p=1");
    }
    $jasenet = pg_query($yhteys, "SELECT ryhmänjäsen FROM RyhmäNimi where Ryhmännimi=('$ryhmannimi') order by ryhmänjäsen");

    echo "<h2 class=\"ryhmah2\">Ryhmän " . $ryhmannimi . " käyttäjät</h2><h2 class=\"ryhmah2\">Muut käyttäjät</h2>";
    echo "<form class=\"ryhmaform\" method=\"post\" action=\"poistaKayttajaRyhmasta.php\">";  
    echo "<input type=\"hidden\" value=\"" . $ryhmannimi . "\" name=\"ryhmannimi\">";    
    echo "<select class=\"ryhmaselect\" size=\"4\" name=\"jasen\">";
  
    $kayttajat = array(); // Taulukko ryhmän käyttäjistä

    while($jasen = pg_fetch_array($jasenet)) {
       echo "<option value=\"" . $jasen["ryhmänjäsen"] . "\">" . $jasen["ryhmänjäsen"] . "</option>";
       array_push($kayttajat, $jasen["ryhmänjäsen"]); // Lisätään ryhmän taulukkoon jäsen
    }
    echo "</select>";
    echo "<input class=\"isosubmit\" type=\"submit\" value=\">\" />";
    echo "</form>";
    
    // Tehdää String taulukon alkioista kyselyä varten
    $maar = "";    
    foreach($kayttajat as $alkio) {
      $maar = $maar . " and Käyttäjänimi != '" . $alkio . "'";
    }

    // Haetaan kaikki paitsi ryhmän jäsenet
    $toiset = pg_query($yhteys, "SELECT käyttäjänimi FROM Käyttäjä where Käyttäjänimi!=('$kayttajat[0]')$maar order by käyttäjänimi");
     
    echo "<form class=\"ryhmaform\" method=\"post\" action=\"lisaaKayttajaRyhmaan.php\">";  
    echo "<input type=\"hidden\" value=\"" . $ryhmannimi . "\" name=\"ryhmannimi\">";
    echo "<input class=\"isosubmit\" type=\"submit\" value=\"<\" />";

    echo "<select class=\"ryhmaselect\" size=\"4\" name=\"jasen\">";

   
    while($jasen = pg_fetch_array($toiset)) {
       echo "<option value=\"" . $jasen["käyttäjänimi"] . "\">" . $jasen["käyttäjänimi"] . "</option>";
    }
    echo "</select>";
    
    echo "</form>";

}

function uusiRyhma() {
  echo "<pre><form method=\"post\" action=\"uusiRyhma.php\">"; 
  echo "Ryhmän nimi:	<input type=\"text\" name=\"nimi\" autofocus placeholder=\"Ryhmän nimi\" maxlength=\"19\" required>\n";
  echo "<input type=\"submit\">";
  echo "</form></pre>";
}
?>
