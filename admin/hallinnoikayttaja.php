<!DOCTYPE html>
<head>
<title>Käyttäjän poisto</title>
</head>
<body>
<form name="Etsi käyttäjä" action="pkayttaja.php" method="post" >
Käyttäjänimi:<input type="text" name="käyttäjänimi" required placeholder="Käyttäjänimi" /><br>
<input name="poista" type="submit" value="Poista" />
<input name="muokkaa" type="submit" value="Muokkaa" />
</form>
<?php 
  session_start();
  if($_SESSION["admin"] == 't'){
   function tulostaSamankaltaiset($haettava) {
    include("../yhteys.php");
    echo "<br><p>Käyttäjää ".$haettava." ei löytynyt</p>";
    echo "<br><p>Samankaltaiset nimet</p>";
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
    echo "<form name=\"Muokkaa käyttäjää\" action=\"mkayttaja.php\" method=\"post\" >"
       . "Käyttäjänimi:<input type=\"text\" name=\"käyttäjänimi\" value=\"" . $nimi . "\" /><br>"
       . "Sähköposti:<input type=\"text\" name=\"sähköposti\" value=\"" . $sahkoposti . "\" /><br>"
       . "<input type=\"hidden\" name=\"vanhakäyttäjänimi\" value=\"" . $nimi . "\" />"
       . "Uusi ylläpitäjä? <select name=\"admin\">"
       .  "<option value=\"f\" selected>Ei</option>"
       .  "<option value=\"t\">Kyllä</option>"
       .  "</select><br>"
       .  "<input type=\"submit\" value=\"Vahvista\" />";
   }
   function listaaKayttajat(){
    include("../yhteys.php");
    $kysely = pg_query($yhteys, "SELECT käyttäjänimi,sähköposti FROM Käyttäjä order by käyttäjänimi");
    echo "<table>
           <tr>
             <th>Käyttäjänimi</th>
             <th>Sähköposti</th>
           </tr>";
    while ($rivi = pg_fetch_array($kysely)) {
     echo "<tr>
             <td>" . $rivi["käyttäjänimi"] . "</td>
             <td>" . $rivi["sähköposti"] . "</td>
           </tr>";
    }
    echo "</table><br>";
   }
  }
  else {
   header('HTTP/1.1 403 Forbidden'); 
  }
?>
</body>
</html>
