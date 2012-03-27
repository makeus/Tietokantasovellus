<!DOCTYPE html>
<head>
<title>Käyttäjän lisäys</title>
</head>
<body>
<?php
     if(session_is_registered("käyttäjänimi")){
   ?>
<form name="käyttäjän lisäys" action="klisays.php" method="POST" >
Käyttäjänimi:<input type="text" name="knimi" required placeholder="Käyttäjänimi" /><br>
Sähköposti:<input type="text" name="sposti" required placeholder="Sähköposti" /><br>
Salasana:<input type="password" name="ssana" required placeholder="Salasana"/><br>
Uusi ylläpitäjä? <input type="boolean" name="admin" required placeholder="T/F" />
<input type="submit" />
</form>
</body>
</html>
<?php}
else {
echo "<p>Ei tänne =D!</p>"
}  ?>
<?php
$db = pg_connect("host=localhost dbname=keus user=keus password=a646a8dd503014f5");
$kysely = "INSERT INTO Käyttäjä VALUES ('$_POST[knimi]','$_POST[sposti]','$_POST[ssana]','$_POST[admin]')";
$tulos = pg_query($kysely); 
?>
