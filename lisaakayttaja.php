<!DOCTYPE html>
<head>
<title>Käyttäjän lisäys</title>
</head>
<body>
<form name="käyttäjän lisäys" action="klisays.php" method="post" >
Käyttäjänimi:<input type="text" name="knimi" required placeholder="Käyttäjänimi" /><br>
Sähköposti:<input type="text" name="sposti" required placeholder="Sähköposti" /><br>
Salasana:<input type="password" name="ssana" required placeholder="Salasana"/><br>
Uusi ylläpitäjä? <input type="boolean" name="admin" required placeholder="T/F" />
<input type="submit" />
</form>
</body>
</html>
