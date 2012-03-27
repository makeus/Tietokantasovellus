<?php
    $yhteys = pg_connect("dbname=keus user=keus password=a646a8dd503014f5"); 
    if($yhteys == FALSE) {
      echo "Tietokantayhteys epäonnistui!";
    }
?>
