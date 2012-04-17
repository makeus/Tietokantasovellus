<?php

session_start();
include_once '../tietokanta/kyselyt.php';
include_once '../logiikka/kayttajafunktiot.php';
$kayttajanimi = escape(htmlspecialchars($_POST["käyttäjänimi"]));
$salasana = escape($_POST["salasana"]);


$kysely = getLogindata($kayttajanimi, $salasana);
 if (!empty($kysely)) {
    $_SESSION["käyttäjänimi"] = $kysely["käyttäjänimi"];
    $_SESSION["admin"] = $kysely["ylläpitäjä"];
    header("Location: /");
} else {
    header("Location: /?e=1");
}
?>

