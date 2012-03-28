<!DOCTYPE html>
<head>
<title>Käyttäjän poisto</title>
</head>
<body>
<form name="Etsi käyttäjä" action="pkayttaja.php" method="post" >
Käyttäjänimi:<input type="text" name="käyttäjänimi" required placeholder="Käyttäjänimi" /><br>
<input type="submit" />
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
    while($kayttaja = pg_fetch_array($kayttajat)) {
     echo "<br><p>".$kayttaja[0]."</p>";
    }
   }
  }
  else {
   header('HTTP/1.1 403 Forbidden'); 
  }
?>
</body>
</html>
