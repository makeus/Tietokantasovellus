<pre><form name="Etsi käyttäjä" action="pkayttaja.php" method="post" >Käyttäjänimi:	<input type="text" name="käyttäjänimi" required autofocus placeholder="Käyttäjänimi" />
<input name="muokkaa" type="submit" value="Muokkaa" /> <input name="poista" type="submit" value="Poista" />
</form>
</pre>
<?php 
  session_start();
  if($_SESSION["admin"] == 't'){
   function tulostaSamankaltaiset($haettava) {
    include("../yhteys.php");
    echo "<p class=\"virhe\">Käyttäjää ".$haettava." ei löytynyt</p>";
    echo "<p>Samankaltaiset nimet</p>";
    $kayttajat = pg_prepare($yhteys, "haku" ,'SELECT Käyttäjänimi FROM Käyttäjä WHERE Käyttäjänimi LIKE $1');
    $kayttajat = pg_execute($yhteys, "haku", array('%' . $haettava . '%'));
    echo "<table>
           <tr>
             <th>Käyttäjänimi</th>
           </tr>";
    while($kayttaja = pg_fetch_array($kayttajat)) {
     echo "<tr>
             <td>" . $kayttaja[0] . "</td>
           </tr>";
    }
    echo "</table><br>";
    }
   function avaaMuokkaus($nimi,$sahkoposti,$yllapitaja){
    echo "<pre><form name=\"Muokkaa käyttäjää\" action=\"mkayttaja.php\" method=\"post\" >"
       . "Käyttäjänimi:	<input type=\"text\" name=\"käyttäjänimi\" autofocus value=\"" . $nimi . "\" />\n"
       . "Sähköposti:	<input type=\"text\" name=\"sähköposti\" value=\"" . $sahkoposti . "\" />\n"
       . "<input type=\"hidden\" name=\"vanhakäyttäjänimi\" value=\"" . $nimi . "\" />"
       . "Ylläpitäjä? 	<select name=\"admin\">"
       .  "<option value=\"f\" selected>Ei</option>"
       .  "<option value=\"t\">Kyllä</option>"
       .  "</select>\n"
       .  "<input type=\"submit\" value=\"Vahvista\" /></form></pre>";
   }
   function listaaKayttajat(){
    include("../yhteys.php");
    $kysely = pg_query($yhteys, "SELECT käyttäjänimi, sähköposti, ylläpitäjä FROM Käyttäjä order by käyttäjänimi");
    echo "<table>
           <tr>
             <th>Käyttäjänimi</th>
             <th>Sähköposti</th>
             <th>Ylläpitäjä</th>
           </tr>";
    while ($rivi = pg_fetch_array($kysely)) {
     echo "<tr>
             <td>" . $rivi["käyttäjänimi"] . "</td>
             <td>" . $rivi["sähköposti"] . "</td>
             <td>"; if($rivi["ylläpitäjä"] == t){echo "Kyllä";} else {echo "Ei";} echo "</td> 
           </tr>";
    }
    echo "</table><br>";
   }
  }
  else {
   header('HTTP/1.1 403 Forbidden'); 
  }
?>
