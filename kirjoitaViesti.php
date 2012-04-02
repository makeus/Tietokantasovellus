<?php
include("tarkista.php");
if(count($nakyvyys) == 0) {
  echo "<p id=\"eiviesteja\">Ei mitään, minne kirjoittaa :L</p>";
}
else {
    if(isset($_GET["v"])){
      tulostaTeksti($_GET["v"]);
    } 
    else {
      echo "<form method=\"post\" action=\"lisaaViesti.php\"><br/>\n";
      echo "<table>\n";
      echo "  <tr>\n";
      echo "   <td colspan=\"2\" class=\"kategoria\">Kirjoita Viesti</td>\n";
      echo "  </tr>\n";
      echo "  <tr>\n";
      echo "   <td class=\"viestilotsikko\">Otsikko:</td>\n";
      echo "   <td><input id=\"kirjoitaviestiotsikko\" type=\"text\" name=\"otsikko\" maxlength=\"64\" required autofocus /></td>\n";
      echo "  </tr>\n";
      echo "  <tr>\n";
      echo "   <td class=\"viestilotsikko\">Kategoria:</td>\n";
      echo "   <td><select id=\"kategoriavaihtoehdot\" name=\"kategoria\">\n";

      // Kategoriavaihtoehdot
      foreach($nakyvyys as &$kid){
        $kategoria = pg_query($yhteys, "SELECT kategoriannimi FROM Kategoria where id=('$kid')");
        $kategorianimi = pg_fetch_row($kategoria);
        echo "    <option value=\"" . $kid . "\">" . $kategorianimi[0] . "</option>\n";
     }

      echo "   </select></td>\n";
      echo "  </tr>\n"; 
    }
    echo "  <tr>\n";
    echo "    <td class=\"viestilotsikko\">Viesti:</td>\n";
    echo "    <td><textarea name=\"teksti\" required rows=\"15\" cols=\"70\" tabindex=\"0\" "; if(isset($_GET["v"])){echo "autofocus";} echo "></textarea></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"viestilotsikko\"></td>\n";
    echo "    <td><input type=\"submit\" name=\"Lähetä!\" /></td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</form>\n";
}
function tulostaTeksti($id) {    
    include("yhteys.php");
    $viestit = pg_query($yhteys, "SELECT Id, Otsikko, teksti, kategoria, kirjoittaja, aika FROM Viesti where id=('$id')");
    $viesti = pg_fetch_row($viestit);
    $kategoria = pg_query($yhteys, "SELECT KategorianNimi FROM Kategoria where id=('$viesti[3]')");
    $kategoriannimi = pg_fetch_row($kategoria);    

    echo "<table>\n";
    echo "  <tr>\n";
    echo "   <td colspan=\"2\" class=\"kategoria\">" . $viesti[1] . "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "   <td colspan=\"1\" class=\"pikkuteksti\">" . $viesti[4] . " (" . date("d.m.y H:i:s", strtotime($viesti[5])) . ")</td>\n";
    echo "   <td colspan=\"1\" class=\"pikkuteksti\">" . $kategoriannimi[0] . "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "   <td id=\"isoteksti\">" . $viesti[2] . "<td>\n";
    echo "  </tr>\n";
    echo "</table><br>\n";
    echo "<form method=\"post\" action=\"lisaaViesti.php\">";
    echo "<input type=\"hidden\" name=\"vastaus\" value=\"" . $viesti[0] . "\" />\n";
    echo "<input type=\"hidden\" name=\"kategoria\" value=\"" . $viesti[3] . "\"/>\n";
    echo "<table>\n";
    echo "  <tr>\n";
    echo "   <td colspan=\"2\" class=\"kategoria\">Kirjoita Vastaus</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "   <td class=\"viestilotsikko\">Otsikko:</td>\n";
    echo "   <td><input id=\"kirjoitaviestiotsikko\" type=\"text\" name=\"otsikko\" maxlength=\"64\" value=\"Re: " . $viesti[1] . "\" required/></td>\n";
    echo "  </tr>\n";

}
?>
