<?php
    include("tarkista.php");
    echo "<table>";
    foreach($nakyvyys as &$kid){
      $kategoria = pg_query($yhteys, "SELECT kategoriannimi FROM Kategoria where id=('$kid')");
      $kategorianimi = pg_fetch_row($kategoria);
      $otsikot = pg_query($yhteys, "SELECT otsikko, aika, kirjoittaja, id FROM viesti where kategoria=('$kid') and vastaus is null order by aika");
      $ekarivi = pg_fetch_row($otsikot);
      

      // Jos ei viestejä kategoriassa, ei tulosteta mitään.

      if($ekarivi != NULL) {
        echo "<tr>";
        echo "<td colspan=\"100%\" class=\"kategoria\">" . $kategorianimi[0] . "</td>\n";
        echo "</tr>";
        echo "<tr class=\"otsikko\">"; 
        echo "<td>" . $ekarivi[0] . "</td>";
        echo "<td>" . $ekarivi[2] . "</td>";
        echo "<td>" . date("d.m.y", strtotime(etsiViimeisinViesti($ekarivi[3], $ekarivi[1]))) . "</td>";	        		
        echo "</tr>";

        while($otsikko = pg_fetch_array($otsikot)) {
          echo "<tr class=\"otsikko\">";
          echo "<td>" . $otsikko[0] . "</td>";
          echo "<td>" . $otsikko[2] . "</td>";
          echo "<td>" . date("d.m.y", strtotime(etsiViimeisinViesti($otsikko[3], $otsikko[1]))) . "</td>";	
          echo "</tr>";
        }
      }
    }
    echo "</table>";
    

function etsiViimeisinViesti($id, $uusin) {
    include("yhteys.php");
    $palautus = $uusin;
    $vastaukset = pg_query($yhteys, "SELECT id, vastaus, aika FROM Viesti where vastaus = ('$id')");
    
    while($vastaus = pg_fetch_array($vastaukset)) {
       $palautus = max($uusin, etsiViimeisinViesti($vastaus[0], $vastaus[2]));
    }

    return $palautus;
}

?>
