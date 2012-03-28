<!DOCTYPE html>
<head>
<title>Käyttäjän lisäys</title>
</head>
<body>
<form name="Luo käyttäjä" action="klisays.php" method="post" >
Käyttäjänimi:<input type="text" name="kayttajanimi" required placeholder="Käyttäjänimi" /><br>
Sähköposti:<input type="text" name="sahkoposti" required placeholder="Sähköposti" /><br>
Salasana:<input type="password" name="salasana" required placeholder="Salasana"/><br>
Uusi ylläpitäjä? <select>
  <option value="T">Kyllä</option>
  <option value="F">Ei</option>
</select><br>
<input type="submit" />
</form>
</body>
</html>
