<?php

include ("yhteys.php");
$kayttajanimi = $_SESSION["käyttäjänimi"];
$nakyvyys = array();
$kategoriat = pg_query($yhteys, 'SELECT Näkyvyys, id FROM Kategoria order by id');
while ($rivi = pg_fetch_array($kategoriat)) {
    $ryhmannimi = pg_query($yhteys, "SELECT RyhmänNimi FROM Ryhmä WHERE Id = ('$rivi[0]')");
    $ryhmanimi = pg_fetch_row($ryhmannimi);
    $jasenet = pg_query($yhteys, "SELECT RyhmänJäsen FROM RyhmäNimi WHERE RyhmänNimi=('$ryhmanimi[0]') AND RyhmänJäsen=('$kayttajanimi')");
    $jasen = pg_fetch_row($jasenet);
    if ($jasen[0] == $kayttajanimi) {
        array_push($nakyvyys, $rivi[1]);
    }
}
?>
