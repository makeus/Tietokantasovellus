<?php
    include("tarkista.php");
    if(count($nakyvyys) > 0) {
      echo "<table>\n";
      echo "  <thead>\n";
      echo "    <tr>\n";
      echo "     <th></th>\n";
      echo "     <th>Kirjoittaja</th>\n";
      echo "     <th>Viimeisin vastaus</th>\n";
      echo "  </thead>\n";
    } 
    else {
      echo "<p id=\"eiviesteja\">Ei viestejä :L</p>";
    }  

    foreach($nakyvyys as &$kid){
      $kategoria = pg_query($yhteys, "SELECT kategoriannimi FROM Kategoria where id=('$kid')");
      $kategorianimi = pg_fetch_row($kategoria);
      $otsikot = pg_query($yhteys, "SELECT otsikko, aika, kirjoittaja, id, viestinlukeneet FROM viesti where kategoria=('$kid') and vastaus is null order by aika desc");
      $ekarivi = pg_fetch_row($otsikot);
      

      // Jos ei viestejä kategoriassa, ei tulosteta mitään.

      if($ekarivi != NULL) {
        echo "  <tr>\n";
        echo "    <td colspan=\"3\" class=\"kategoria\">" . $kategorianimi[0] . "</td>\n";
        echo "  </tr>\n";        
        echo "  <tr class=\"otsikko\">\n"; 
	        
	if(($ekarivi[4] != null) && (in_array($kayttajanimi, pg_array_parse($ekarivi[4], FALSE))) &&  etsiOnkoLukenut($kayttajanimi, $ekarivi[3])){
           echo "    <td>" . $ekarivi[0];
        } 
        else {
           echo "   <td class=\"lukematon\">" . $ekarivi[0] . " !";
        }
	echo "     </td>\n";
        echo "     <td>" . $ekarivi[2] . "</td>\n";
        echo "     <td>" . date("d.m.y H:i:s", strtotime(etsiViimeisinViesti($ekarivi[3], $ekarivi[1]))) . "</td>\n";	        		
        echo "  </tr>\n";

        while($otsikko = pg_fetch_array($otsikot)) {
          echo "  <tr class=\"otsikko\">\n";
          
	  if(($otsikko[4] != null) && (in_array($kayttajanimi, pg_array_parse($otsikko[4], FALSE))) &&  etsiOnkoLukenut($kayttajanimi, $otsikko[3])){
             echo "    <td>" . $otsikko[0];
          } 
          else {
             echo "    <td class=\"lukematon\">" . $otsikko[0] . " !";
          }
	  echo "    </td>\n";
          echo "    <td>" . $otsikko[2] . "</td>\n";
          echo "    <td>" . date("d.m.y H:i:s", strtotime(etsiViimeisinViesti($otsikko[3], $otsikko[1]))) . "</td>\n";	
          echo "  </tr>\n";
        }
      }
    }
    echo "</table>\n";
    

function etsiViimeisinViesti($id, $uusin) {
    include("yhteys.php");
    $palautus = $uusin;
    $vastaukset = pg_query($yhteys, "SELECT id, aika FROM Viesti where vastaus = ('$id')");
    
    while($vastaus = pg_fetch_array($vastaukset)) {
       $palautus = max($uusin, etsiViimeisinViesti($vastaus[0], $vastaus[1]));
    }
    return $palautus;
}

function etsiOnkoLukenut($kayttajanimi, $id) {
    include("yhteys.php");
    $palautus = TRUE;
    $vastaukset = pg_query($yhteys, "SELECT id, viestinlukeneet FROM Viesti where vastaus = ('$id')");
    
    while($vastaus = pg_fetch_array($vastaukset)) {
       if(($vastaus[1] == null) or (!in_array($kayttajanimi, pg_array_parse($vastaus[1], FALSE)))){
           $palautus = FALSE;  
       } else {
           $palautus = etsiOnkoLukenut($kayttajanimi, $vastaus[0]);
       }
    }
    return $palautus;
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
