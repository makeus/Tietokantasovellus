<?php
  session_start();
  if($_SESSION["admin"] == 't'){
    include("../yhteys.php");
    $kysely = pg_prepare($yhteys, "lahetys", 'DELETE FROM Ryhmä WHERE id=($1)');
    $kysely = pg_execute($yhteys, "lahetys", array($_GET["id"]));
    header("Location: http://keus.users.cs.helsinki.fi/admin/admin.php?p=1");
  } else {
    header('HTTP/1.1 403 Forbidden');
  }
?>
