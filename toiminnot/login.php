<?php

session_start();

$_SESSION["käyttäjänimi"] = "temp";

include_once '../tietokanta/kyselyt.php';

$kayttajanimi = escape(htmlspecialchars($_POST["käyttäjänimi"]));
$salasana = escape($_POST["salasana"]);
$kysely = getLogindata($kayttajanimi, $salasana);
session_unset();

if (!empty($kysely)) {
    $_SESSION["käyttäjänimi"] = $kysely["käyttäjänimi"];
    $_SESSION["admin"] = $kysely["ylläpitäjä"];
    header("Location: /");
} else {
    header("Location: /?e=1");
}

/*
 * Hakee käyttäjän tunnuksen ja ylläpitotilanteen tunnuksen ja salasanan perusteella
 */

function getLogindata($kayttajatunnus, $salasana) {
    include_once '../tietokanta/kyselyt.php';
    $vastaukset = select("Käyttäjänimi, Ylläpitäjä", "käyttäjä", "Käyttäjänimi = '$kayttajatunnus' and Salasana = '$salasana'");
    return $vastaukset[0];
}
?>

