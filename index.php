<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>

        <title>Työryhmätiedoitus</title>
        <LINK rel="stylesheet" type="text/css" href="tyylit.css"/>
        <script type="text/javascript">
            function varmista(url, viesti){
                if(confirm(viesti)) {
                    window.location = url;
                }
            }
            
            function naytaLukeneet(id){
                var e = document.getElementById(id);
                var link = document.getElementById("link" + id);
                
                if(e.style.visibility == 'visible') {
                    e.style.visibility = 'hidden';
                    link.textContent = "Näytä";
                }
                else {
                    e.style.visibility = 'visible';
                    link.textContent = "Piilota";
                }
            }
            var hakuNappi;
            window.onload = function(){
                hakuNappi = document.querySelector("#hakunappi");
                hakuNappi.addEventListener('click',naytaHaku,false);
            }
            function naytaHaku(evt){
                var e = document.querySelector("#hakija");
                if(e.style.display == 'block') {
                    e.style.display = 'none';
                }
                else {
                    e.style.display = 'block';
                    e.style.left = (evt.pageX-30)+'px';
                    e.style.top = (evt.pageY+20)+'px';
                }
            }
            
        </script>
    </head>
    <body>
        <div class="sivupalkki"></div>
        <div id="keskipalkki">
            <h1>Työryhmätiedoitus</h1>
            <?php
            if (!session_is_registered("käyttäjänimi")) {
                ?>

                <section id="kirjautuminen">
                    <h1>Kirjaudu sisään!</h1>
                    <form action="toiminnot/login.php" method="post">
                        <table id="logintable">
                            <tr>
                                <td>Käyttäjänimi</td>
                                <td><input type="text" name="käyttäjänimi" autofocus required /></td>
                            </tr>
                            <tr>
                                <td>Salasana</td> 
                                <td><input type="password" name="salasana" required /></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" id="kirjaudusubmit" value="Kirjaudu!" /></td>
                            </tr>
                        </table>
                    </form>
                    <?php
                    if (isset($_GET["e"])) {
                        echo "<p id=\"eiviesteja\">Väärä käyttäjänimi tai salasana!</p>\n";
                    }
                    ?>
                </section>

            <?php } else {
                ?>

                <!-- Tulostetaan nav ja asetetaan nykyne arvo nykyiseen sivuun -->

                <nav>
                    <a href="/" <?php
            if ((!isset($_GET["p"])) or ($_GET["p"] == 1)) {
                echo "id=\"nykyne\"";
            }
                ?>>Etusivu</a>
                    <a href="/?p=2" <?php
                   if ((isset($_GET["p"])) and ($_GET["p"] == 2)) {
                       echo "id=\"nykyne\"";
                   }
                ?>>Kirjoita viesti</a>
                       <?php
                       if ($_SESSION["admin"] == 't') {
                           echo "<a href=\"admin/admin.php?p=1\">Ylläpito</a>\n";
                       }
                       ?>
                    <a href="toiminnot/logout.php"> Kirjaudu ulos </a>
                    <a id="hakunappi">Haku</a>
                    <div id="hakija"><form name="haku" action="index.php?p=4" method="post">
                    <input type="text" placeholder="Käyttäjänimi" name="kayttajanimi"/>
                    <input type="text" placeholder="Hakusana" name="hakusana"/>
                    <input type="submit"/></form></div>
                </nav>
                <section>

                    <!-- Kirjautumistieto ja aika -->
                    <div id="välipalkki">
                        <p class="väliteksti">Kirjautuneena käyttäjänä <strong><?php echo $_SESSION["käyttäjänimi"]; ?></strong></p>
                        <p class="väliteksti"><?php echo date("d.m.y H:i:s", $_SERVER['REQUEST_TIME']); ?></p>
                    </div>
                    <?php
                    /*
                     * Näytettävä sivu
                     */
                    if ((!isset($_GET["p"])) or ($_GET["p"] == 1)) {
                        include("tulostaKategoriat.php");
                    } elseif ($_GET["p"] == 2) {
                        include("kirjoitaViesti.php");
                    } elseif ($_GET["p"] == 3) {
                        include("tulostaViesti.php");
                    } elseif ($_GET["p"] == 4){
                        include("tulostaHaku.php");
                    }
                    ?>
                </section>
            <?php } ?>
        </div>
        <div class="sivupalkki"></div>
    </body>
</html>
