<?php
  function tulostaRyhmat(){
   session_start(); 
   if($_SESSION["käyttäjänimi"] == 'admin'){

    include("../yhteys.php");
    $kysely = pg_query($yhteys, "SELECT * FROM Viesti");
    echo "<table>
           <tr>
             <th>ID</th>
             <th>Aika</th>
             <th>Kirjoittaja</th>
             <th>Teksti</th>
             <th>Poista</th>
           </tr>";
    while ($rivi = pg_fetch_array($kysely)) {
     echo "<tr>
             <td>" . $rivi["id"] . "</td>
             <td>" . $rivi["aika"] . "</td>
             <td>" . $rivi["teksti"] . "</td>
             <td> <a href=poistaRyhma.php?id=" . $rivi["id"] . ">x</a></td>
           </tr>";
    }
    echo "</table><br>";
  }
  else { 
    header('HTTP/1.1 403 Forbidden');
  }
}
?>
