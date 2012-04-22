<?php

if (!session_is_registered("käyttäjänimi")) {
    header("HTTP/1.1 403 Forbidden");
} else {

    /*
     * Hakee kategorian nimen id:n perusteella
     */

    function getKategoriannimi($id) {
        include_once 'tietokanta/kyselyt.php';

        $kategoriat = select("kategoriannimi", "kategoria", "id=('$id')");
        $kategoriannimi = $kategoriat[0];
        return $kategoriannimi["kategoriannimi"];
    }

    /*
     * Hakee parametrinä annetulle käyttäjälle sallitut kategoriat.
     * Palauttaa taulukollisen kategoriaid:tä.
     */

    function getNakyvyys($kayttajanimi) {
        include_once 'tietokanta/kyselyt.php';
        include_once 'logiikka/viestifunktiot.php';

        $nakyvyys = array();
        
        $kategoriat = selectorder("Näkyvyys, id", "Kategoria", "id");
        
        foreach ($kategoriat as $rivi) {
            $katnakyvyys = $rivi["näkyvyys"];
            $ryhmannimi = getRyhmannimi($katnakyvyys);
            $jasenet = select("RyhmänJäsen", "RyhmäNimi", "RyhmänNimi=('$ryhmannimi') AND RyhmänJäsen=('$kayttajanimi')");
            $jasen = $jasenet[0];
            if ($jasen["ryhmänjäsen"] == $kayttajanimi) {
                array_push($nakyvyys, $rivi["id"]);
            }
        }
        return $nakyvyys;
    }

}
?>
