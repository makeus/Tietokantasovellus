<?php
  function tulostaKategoriat(){
   session_start(); 
   
   if($_SESSION["admin"] == 't'){

    include("../yhteys.php");
    $kategoriat = pg_query($yhteys, 'SELECT * FROM Kategoria order by id');

    // Taulukon otsikko
    echo "<table>
           <tr>
             <th>ID</th>
             <th>Kategorian nimi</th>
             <th>Näkyvyys</th>
             <th>Muokkaa</th>
             <th>Poista</th>
           </tr>";    

    while ($rivi = pg_fetch_array($kategoriat)) {
    $nakyvyys = $rivi["näkyvyys"];
    $ryhmat = pg_query($yhteys, "SELECT ryhmännimi FROM Ryhmä where id=('$nakyvyys')");
    $ryhmarivi = pg_fetch_row($ryhmat);    
    $ryhmannimi = $ryhmarivi[0];

     echo "<tr>
             <td>" . $rivi["id"] . "</td>
             <td>" . $rivi["kategoriannimi"] . "</td>
             <td>" . $ryhmannimi . "</td>
             <td> <a href=\"admin.php?p=5&m=" . $rivi["id"] ."\">x</a></td>";
     echo "</td>
             <td> <a href=# onclick='varmista(\"poistaKategoria.php?id=" . $rivi["id"] . "\", \"Oletko varma, että haluat poistaa kategorian? Poistaminen poistaa myös kategoriaan kuuluvat viestit\")'>x</a></td>
           </tr>";

    }
    echo "</table><br>";
  }
  else { 
    header('HTTP/1.1 403 Forbidden');
  }
}

function muokkaaKategoria($id) {
    include("../yhteys.php");
    $kategoria = pg_query($yhteys, "SELECT * FROM Kategoria where id=('$id')");
    $rivi = pg_fetch_row($kategoria);    
    $kategoriannimi = $rivi[1];
    if(!isset($kategoriannimi)){
      header("Location: admin.php?p=5");
    }
    $ryhmat = pg_query($yhteys, "SELECT * FROM Ryhmä");
    
    echo "<h2>Muokkaa kategoriaa " . $kategoriannimi . "</h2>\n";
    echo "<form method=\"post\" action=\"muokkaaKategoria.php\">\n";
    echo "<input type=\"hidden\" name=\"id\" value=\"" . $rivi[0] . "\"/>";
    echo "<pre>Kategorian nimi:	<input type=\"text\" name=\"nimi\" value=\"" . $kategoriannimi . "\" required />\n";
    echo "Näkyvyys:		<select name=\"nakyvyys\">\n";
    while($ryhmarivi = pg_fetch_array($ryhmat)){      
      echo "<option value=\"" . $ryhmarivi[0] . "\"";
      if ($ryhmarivi[0] == $rivi[2]) {
        echo " selected";
      }
      echo " />" . $ryhmarivi[1] . "</option>\n";
    }
    echo "</select>\n";
    echo "<input type=\"submit\" value=\"Vahvista\" />\n";
    echo "</pre>\n</form>";

}  

function uusiKategoria() {
  include("../yhteys.php");
  $ryhmat = pg_query($yhteys, "SELECT * FROM Ryhmä");
  echo "<pre><form method=\"post\" action=\"uusiKategoria.php\">"; 
  echo "Kategorian nimi:	<input type=\"text\" name=\"nimi\" placeholder=\"Kategorian nimi\" required>\n";
  echo "Näkyvyys:		<select name=\"nakyvyys\">\n";
    while($ryhmarivi = pg_fetch_array($ryhmat)){      
      echo "<option value=\"" . $ryhmarivi[0] . "\"";
      if ($ryhmarivi[0] == $rivi[2]) {
        echo " selected";
      }
      echo " />" . $ryhmarivi[1] . "</option>\n";
    }
    echo "</select>\n";
  echo "<input type=\"submit\">";
  echo "</form></pre>";
}
?>
