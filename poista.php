<?php

session_start();
include("yhteys.php");
$viesti = pg_query_params($yhteys, 'SELECT Kirjoittaja FROM Viesti WHERE Id= $1', array($_GET["id"]));
$kirjoittaja = pg_fetch_array($viesti);
if ($_SESSION["admin"] == 't' || $kirjoittaja[0] == $_SESSION["käyttäjänimi"]) {
    $kysely = pg_prepare($yhteys, "lahetys", 'DELETE FROM Viesti WHERE id=($1)');
    $kysely = pg_execute($yhteys, "lahetys", array($_GET["id"]));
}
header("Location: index.php");
?>
