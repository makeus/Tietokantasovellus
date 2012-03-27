<?php
  function tulostaRyhmat(){
   session_start(); 
   if($_SESSION["käyttäjänimi"] == 'admin'){

    include("../yhteys.php");
    $kysely = $yhteys->prepare("SELECT * FROM Viesti");
    $kysely->execute();
 
    echo "<table>
           <tr>
             <th>ID</th>
             <th>Aika</th>
             <th>Kirjoittaja</th>
             <th>Teksti</th>
             <th>Poista</th>
           </tr>";
    while ($rivi = $kysely->fetch()) {
     echo "<tr>
             <td>" . $rivi["id"] . "</td>
             <td>" . $rivi["aika"] . "</td>
             <td>" . $rivi["kirjoittaja"] . "</td>
             <td>" . $rivi["teksti"] . "</td>
             <td> <a href=poista.php?id=" . $rivi["id"] . ">x</a></td>
           </tr>";
    }
    echo "</table><br>";
    echo '<form action="laheta.php" method="post">
            <input type="text" name="viesti" />
            <input type="submit" value="Lähetä" />
          </form>
          <p><a href="logout.php">Kirjaudu ulos!</a></p>';
  }
  else { 
    header('HTTP/1.1 403 Forbidden');
  }
}
?>
