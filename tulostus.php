<?php
  function tulosta(){
    include("yhteys.php");
    $kysely = $yhteys->prepare("SELECT * FROM teksti");
    $kysely->execute();

    echo "<p>";
    while ($rivi = $kysely->fetch()) {
      echo " <a href=poista.php?viesti=" . $rivi["viesti"] . ">x</a>  " . $rivi["viesti"] . "<br>";
    }
    echo "</p>";
  }
?>
