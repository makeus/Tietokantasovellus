<pre><form name="Etsi käyttäjä" action="ekayttaja.php" method="post" >Käyttäjänimi:	<input type="text" name="käyttäjänimi" required autofocus placeholder="Käyttäjänimi" />
<input name="etsi" type="submit" value="Etsi" />
</form>
</pre>
<?php
function tulostaKayttajat(){
   session_start(); 
   if($_SESSION["admin"] == 't'){
    include("../yhteys.php");
    $kayttajat = pg_query($yhteys, 'SELECT käyttäjänimi,sähköposti,ylläpitäjä FROM Käyttäjä order by käyttäjänimi');
    // Taulukon otsikko
    echo "<table>
           <tr>
             <th>Käyttäjänimi</th>
             <th>Sähköposti</th>
             <th>Ylläpitäjä</th>
             <th>Muokkaa</th>
             <th>Poista</th>
           </tr>";    

    while ($rivi = pg_fetch_array($kayttajat)) {
     echo "<tr>
             <td>" . $rivi["käyttäjänimi"] . "</td>
             <td>" . $rivi["sähköposti"] . "</td>
             <td>" . $rivi["ylläpitäjä"] . "</td>
             <td> <a href=\"admin.php?p=3&muokkaa=" . $rivi["käyttäjänimi"] ."\">x</a></td>";
     echo "</td>
             <td> <a href=# onclick='varmista(\"pkayttaja.php?poista=" . $rivi["käyttäjänimi"] . "\", \"Oletko varma, että haluat poistaa käyttäjän?\")'>x</a></td>
           </tr>";

    }
    echo "</table><br>";
  }
  else { 
    header('HTTP/1.1 403 Forbidden');
  }
}
function tulostaSamankaltaiset($nimi){
   session_start(); 
   
   if($_SESSION["admin"] == 't'){

    include("../yhteys.php");
    $kayttajat = pg_prepare($yhteys, "haku" ,'SELECT Käyttäjänimi FROM Käyttäjä WHERE Käyttäjänimi LIKE $1');
    $kayttajat = pg_execute($yhteys, "haku", array('%' . $nimi . '%'));

    // Taulukon otsikko
    echo "<table>
           <tr>
             <th>Käyttäjänimi</th>
             <th>Sähköposti</th>
             <th>Ylläpitäjä</th>
             <th>Muokkaa</th>
             <th>Poista</th>
           </tr>";    

    while ($rivi = pg_fetch_array($kayttajat)) {
     echo "<tr>
             <td>" . $rivi["käyttäjänimi"] . "</td>
             <td>" . $rivi["sähköposti"] . "</td>
             <td>" . $rivi["ylläpitäjä"] . "</td>
             <td> <a href=\"admin.php?p=3&muokkaa=" . $rivi["käyttäjänimi"] ."\">x</a></td>";
     echo "</td>
             <td> <a href=# onclick='varmista(\"pkayttaja.php?poista=" . $rivi["käyttäjänimi"] . "\", \"Oletko varma, että haluat poistaa käyttäjän?\")'>x</a></td>
           </tr>";

    }
    echo "</table><br>";
  }
  else { 
    header('HTTP/1.1 403 Forbidden');
  }
}

function avaaMuokkaus($nimi){

   session_start();
   if($_SESSION["admin"] == 't'){
     include("../yhteys.php");
     $rivi = pg_prepare($yhteys, "haku" ,'SELECT Käyttäjänimi, Sähköposti FROM Käyttäjä WHERE Käyttäjänimi = $1');
     $rivi = pg_execute($yhteys, "haku", array($nimi));
     $kayttaja = pg_fetch_array($rivi);
     echo "<pre><form name=\"Muokkaa käyttäjää\" action=\"mkayttaja.php\" method=\"post\" >"
       . "Käyttäjänimi:	<input type=\"text\" name=\"käyttäjänimi\" autofocus value=\"" . $nimi . "\" />\n"
       . "Sähköposti:	<input type=\"text\" name=\"sähköposti\" value=\"" . $kayttaja["sähköposti"] . "\" />\n"
       . "<input type=\"hidden\" name=\"vanhakäyttäjänimi\" value=\"" . $nimi . "\" />"
       . "Ylläpitäjä? 	<select name=\"admin\">"
       .  "<option value=\"f\" selected>Ei</option>"
       .  "<option value=\"t\">Kyllä</option>"
       .  "</select>\n"
       .  "<input type=\"submit\" value=\"Vahvista\" /></form></pre>";
   
   }
   else{
     header('HTTP/1.1 403 Forbidden');
   }
}

?>
