<?php
session_start();
if ($_SESSION["admin"] == 't') {  // Jos admin oikeudet on t, eli true!
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Ylläpitosivu</title>
            <LINK rel="stylesheet" type="text/css" href="admin.css"/>
            <script type="text/javascript">
                function varmista(url, viesti){
                    if(confirm(viesti)) {
                        window.location = url;
                    }
                }
            </script>
        </head>
        <body>
            <h1>Ylläpitosivu</h1>
            <div>
                <nav>
                    <h2>Ryhmät</h2>
                    <ul>
                        <li><a href="admin.php?p=1" 
                            <?php
                            if ($_GET["p"] == 1) {
                                echo'id="nykyne"';
                            }
                            ?>>Hallinnoi ryhmiä</a></li>
                        <li><a href="admin.php?p=2" 
                            <?php
                            if ($_GET["p"] == 2) {
                                echo'id="nykyne"';
                            }
                            ?>>Luo ryhmä</a></li>
                    </ul>
                    <h2>Käyttäjät</h2>
                    <ul>
                        <li><a href="admin.php?p=3" 
                            <?php
                            if ($_GET["p"] == 3) {
                                echo'id="nykyne"';
                            }
                            ?>>Hallinnoi käyttäjiä</a></li>
                        <li><a href="admin.php?p=4" 
                            <?php
                            if ($_GET["p"] == 4) {
                                echo'id="nykyne"';
                            }
                            ?>>Luo käyttäjä</a></li>
                    </ul>
                    <h2>Kategoriat</h2>
                    <ul>
                        <li><a href="admin.php?p=5" 
                            <?php
                            if ($_GET["p"] == 5) {
                                echo'id="nykyne"';
                            }
                            ?>>Hallinnoi kategorioita</a></li>
                        <li><a href="admin.php?p=6" 
                            <?php
                            if ($_GET["p"] == 6) {
                                echo'id="nykyne"';
                            }
                            ?>>Luo kategoria</a></li>
                    </ul><br/>
                    <ul>
                        <li><a href="../toiminnot/logout.php">Logout</a></li>
                        <li><a href="../">Etusivu</a></li>
                    </ul>
                </nav>      
                <section>
                    <?php
                    /*
                     * Sivujen valinta
                     * p = null tai 1 -> Hallinnoi ryhmiä
                     * p = 2 -> Luo Ryhmä
                     * p = 3 -> Hallinoi käyttäjiä
                     * p = 4 -> Luo Käyttäjä
                     * p = 5 -> Hallinnoi kategorioita
                     * p = 6 -> Luo Kategoria
                     */
                    if ((!isset($_GET["p"])) || ($_GET["p"] == 1)) {
                        echo "<h1>Hallinnoi ryhmiä</h1>";
                        include("ryhmatulosta.php");
                        tulostaRyhmat();
                        /*
                         * Jos muokkaa-arvo on annettu, avataan muokkausosa.
                         * m:n arvo on ryhmän id
                         */
                        if (isset($_GET["m"])) {
                            muokkaaRyhma($_GET["m"]);
                        }
                    } elseif ($_GET["p"] == 2) {
                        echo "<h1>Luo ryhmä</h1>";
                        include ("ryhmatulosta.php");
                        uusiRyhma();
                        /*
                         * Jos virhe-arvo on annettu
                         * Virhe tässätapauksessa jo olemassaoleva nimi
                         * e:n arvo ryhmän nimi
                         */
                        if (isset($_GET["e"])) {
                            echo "<p class=\"virhe\">Ryhmä " . $_GET["e"] . " löytyy jo!</p>";
                        }
                    } elseif ($_GET["p"] == 3) {
                        echo "<h1>Hallinnoi käyttäjiä</h1>";
                        include("kayttajatulosta.php");
                        /*
                         * Jos virhe-arvo on annettu
                         * Virhe tässätapauksessa jo olemassaoleva nimi
                         * e:n arvo käyttäjän nimi
                         */
                        if (isset($_GET["e"])) {
                            echo "<p class=\"virhe\">Käyttäjänimi " . $_GET["e"] . " löytyy jo!</p>";
                        }
                        /*
                         * Jos sivu on tapahtunut poiston jälkeen
                         * po kuvaa onnistumista
                         * f -> virhe, käyttäjä yrittää poistaa itseään tai poisto epäonnistui
                         * muuten onnistunut ilmoitus tulostetaan.
                         */
                        if (isset($_GET["po"])) {
                            if ($_GET["po"] == "f") {
                                if (isset($_GET["nimi"])) {
                                    echo "<p class\"virhe\">HEI! (Poistossa jotain vikaa)</p>";
                                } else {
                                    echo "<p class=\"virhe\">Et voi poistaa itseäsi!</p>";
                                }
                            } else {
                                echo "<p class=\"ok\">Käyttäjä " . $_GET["po"] . " poistettiin onnistuneesti!</p>";
                            }
                        }
                        /*
                         * Jos m-arvo on annettu
                         * m-arvo kuvaa käyttäjän hakua
                         * tyhjä arvo tulostaa kaikki arvot, muuten etsitään samanlaiset käyttäjät
                         * ei löydetty nimi tuottaa tyhjän taulukon.
                         */
                        if (isset($_GET["m"])) {
                            if ($_GET["m"] == "") {
                                tulostaKayttajat();
                            } else {
                                tulostaSamankaltaiset($_GET["m"]);
                            }
                            /*
                             * Jos muokkaa-arvo on annettu
                             * muokkaa avaa muokkauslomakkeen käyttäjälle
                             * muokkaa-arvo on käyttäjän nimi.
                             * tuntematon nimi antaa virheilmoituksen.
                             */
                        } elseif (isset($_GET["muokkaa"])) {
                            avaaMuokkaus($_GET["muokkaa"]);
                            tulostaKayttajat();
                            /*
                             * Jos ei parametreja, tulostetaan kaikki käyttäjät
                             */
                        } else {
                            tulostaKayttajat();
                        }
                    } elseif ($_GET["p"] == 4) {
                        echo "<h1>Luo käyttäjä</h1>";
                        include("kayttajatulosta.php");
                        uusiKayttaja();
                        /*
                         * Jos virhe-arvo on annettu
                         * Virhe tässätapauksessa jo olemassaoleva nimi
                         * e:n arvo käyttäjän nimi
                         * Ok ilmoittaa onnistuneesta poistosta
                         */
                        if (isset($_GET["e"])) {
                            echo "<p class=\"virhe\">Käyttäjänimi " . $_GET["e"] . " löytyy jo!</p>";
                        }
                        if (isset($_GET["ok"])) {
                            echo "<p class=\"ok\">Käyttäjänimi " . $_GET["ok"] . " luotiin onnistuneesti!</p>";
                        }
                    } elseif ($_GET["p"] == 5) {
                        echo "<h1>Hallinnoi kategorioita</h1>";
                        include("kategoriatulosta.php");
                        tulostaKategoriat();
                        if (isset($_GET["m"])) {
                            muokkaaKategoria($_GET["m"]);
                        }
                    } elseif ($_GET["p"] == 6) {
                        echo "<h1>Luo kategoria</h1>";
                        include ("kategoriatulosta.php");
                        uusiKategoria();
                        /*
                         * Jos virhe-arvo on annettu
                         * Virhe tässätapauksessa jo olemassaoleva nimi
                         * e:n arvo kategorian nimi
                         */
                        if (isset($_GET["e"])) {
                            echo "<p class=\"virhe\">Kategoria " . $_GET["e"] . " löytyy jo!</p>";
                        }
                    }
                    ?>
                </section>
            </div>
        </body>
    </html>

    <?php
} else {
    header('HTTP/1.1 403 Forbidden');
}
?>
