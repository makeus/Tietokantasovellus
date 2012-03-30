<?php
    include("tarkista.php");
    echo "<table>";
    foreach($nakyvyys as &$kid){
      $kategoria = pg_query($yhteys, "SELECT kategoriannimi FROM Kategoria where id=('$kid')");
      $kategorianimi = pg_fetch_row($kategoria);
      $otsikot = pg_query($yhteys, "SELECT otsikko, aika, kirjoittaja FROM viesti where kategoria=('$kid') and vastaus is null order by aika");
      $ekarivi = pg_fetch_row($otsikot);
      
      // Jos ei viestejä kategoriassa, ei tulosteta mitään.
      if($ekarivi != NULL) {
        echo "<tr>";
        echo "<td colspan=\"100%\" class=\"kategoria\">" . $kategorianimi[0] . "</td>\n";
        echo "</tr>";
        echo "<tr class=\"otsikko\">"; 
        echo "<td>" . $ekarivi[0] . "</td>";
        echo "<td>" . $ekarivi[2] . "</td>";
        echo "<td>" . date("d.m.y", strtotime($ekarivi[1])) . "</td>";	        		
        echo "</tr>";
        while($otsikko = pg_fetch_array($otsikot)) {
          echo "<tr class=\"otsikko\">";
          echo "<td>" . $otsikko[0] . "</td>";
          echo "<td>" . $ekarivi[2] . "</td>";
          echo "<td>" . date("d.m.y", strtotime($otsikko[1])) . "</td>";	
          echo "</tr>";
        }
      }
    }
    echo "</table>";
    

?>
