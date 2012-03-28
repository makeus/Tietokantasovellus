<!DOCTYPE html>
<head>
<title>Käyttäjän lisäys</title>
</head>
<body>
<form name="Luo käyttäjä" action="klisays.php" method="post" >
Käyttäjänimi:<input type="text" name="kayttajanimi" required placeholder="Käyttäjänimi" /><br>
Sähköposti:<input type="text" name="sahkoposti" placeholder="Sähköposti" /><br>
Salasana:<input type="password" name="salasana" required placeholder="Salasana"/><br>
Uusi ylläpitäjä? <select name="admin">
  <option value="t" selected>Kyllä</option>
  <option value="f">Ei</option>
</select><br>
<input type="submit" />
</form>
</body>
</html>
