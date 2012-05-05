<?php

if ((!session_is_registered("käyttäjänimi")) or ($_SESSION["admin"] != 't')) {
    header("HTTP/1.1 403 Forbidden");
} else {

    /*
     * Tarkistaa onko ryhmännimi varattu
     */
    
    function tarkistaRyhmaNimi($nimi) {
        
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
    
    /*
     * Tarkistaa onko kategoriannimi varattu
     * Ei varsinaisesti käytössä, koska kategoriannimi ei tarvitse olla uniikki
     */

    function tarkistaKategorianNimi($nimi) {

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
    
    /*
     * Tarkistaa onko käyttäjänimi varattu
     */

    function tarkistaKayttaja($nimi) {

        $kayttajat = selectorder("Käyttäjänimi", "Käyttäjä", "Käyttäjänimi");
        $loytyy = FALSE;
        if (!empty($kayttajat)) {
            foreach ($kayttajat as $rivi) {
                if ($rivi["käyttäjänimi"] == $nimi) {
                    $loytyy = TRUE;
                }
            }
        }
        return $loytyy;
    }

}
?>
