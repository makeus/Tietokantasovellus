<?php
$nimi=$_POST["käyttäjänimi"];
header("Location: ../admin.php?p=3&m=".urlencode($nimi));
?>
