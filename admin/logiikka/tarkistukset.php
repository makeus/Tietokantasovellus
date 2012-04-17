<?php

if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {

    function tarkistaRyhmaNimi($nimi) {
        include_once ("../../tietokanta/kyselyt.php");


        $ryhmat = selectorder("Ryhmännimi", "Ryhmä", "Ryhmännimi");
        $loytyy = FALSE;
        if (!empty($ryhmat)) {
            foreach ($ryhmat as $rivi) {
                if ($rivi["ryhmännimi"] == $nimi) {
                    $loytyy = TRUE;
                    break;
                }
            }
        }
        return $loytyy;
    }

    function tarkistaKategorianNimi($nimi) {
        include_once ("../../tietokanta/kyselyt.php");

        $kategoriat = selectorder("KategorianNimi", "Kategoria", "KategorianNimi");
        $loytyy = FALSE;
        if (!empty($kategoriat)) {
            foreach ($kategoriat as $rivi) {
                if ($rivi["KategorianNimi"] == $nimi) {
                    $loytyy = TRUE;
                }
            }
        }
        return $loytyy;
    }

    function tarkistaKayttaja($nimi) {
        include_once ("../../tietokanta/kyselyt.php");

        $kayttajat = seletorder("Käyttäjänimi", "Käyttäjä", "Käyttäjänimi");
        $loytyy = FALSE;
        if (!empty($kayttajat)) {
            foreach ($kayttajat as $rivi) {
                if ($rivi["Käyttäjänimi"] == $nimi) {
                    $loytyy = TRUE;
                }
            }
        }
        return $loytyy;
    }

}
?>
