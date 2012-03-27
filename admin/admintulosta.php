<?php
  function tulostaRyhmat(){
   session_start(); 
   
   if($_SESSION["admin"] == 't'){


    // "valmistellaan" molemmat haut, ja haetaan ryhmät
    include("../yhteys.php");
    $ryhmat = pg_prepare($yhteys, "ryhmat", 'SELECT * FROM Ryhmä');
    $ryhmat = pg_execute($yhteys, "ryhmat", array());
    $jasenet = pg_prepare($yhteys, "jasenet", 'SELECT Ryhmänjäsen FROM RyhmäNimi WHERE ryhmännimi=$1');

    // Taulukon otsikko
    echo "<table>
           <tr>
             <th>ID</th>
             <th>Ryhmän nimi</th>
             <th>Ryhmän jäsenet</th>
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
             <td> <a href=# onclick='varmista(\"poistaRyhma.php?id=" . $rivi["id"] . "\")'>x</a></td>
           </tr>";
    }
    echo "</table><br>";
  }
  else { 
    header('HTTP/1.1 403 Forbidden');
  }
}
?>
