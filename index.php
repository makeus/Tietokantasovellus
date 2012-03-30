<?php
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Työryhmätiedoitus - Kirjaudu sisään!</title>
    <LINK rel="stylesheet" type="text/css" href="tyylit.css"/>
  </head>
  <body>
   <div class="sivupalkki"></div>
   <div id="keskipalkki">
     <h1>Työryhmätiedoitus</h1>
     <?php
       if(!session_is_registered("käyttäjänimi")){
     ?>

     <section id="kirjautuminen">
       <h1>Kirjaudu sisään!</h1>
       <form action="login.php" method="post"><pre>
Käyttäjänimi		<input type="text" name="käyttäjänimi" required />
Salasana 		<input type="password" name="salasana" required />
<input type="submit" id="kirjaudusubmit" value="Kirjaudu!" /></pre>
       </form>
     </section>

     <?php }
     else {?>
     <nav>
       <a href="/">Etusivu</a>
       <a href=#>Kirjoita viesti</a>
       <?php if($_SESSION["admin"] == 't'){echo "<a href=\"admin\admin.php?p=1\">Ylläpito</a>";}?>
       <a href="logout.php"> Kirjaudu ulos </a>
     </nav>
     <section>
       <?php
       if((!isset($_GET["p"])) or ($_GET["p"] == 1)){
         include("tulostaKategoriat.php");
       }
       elseif($_GET["p"] == 2){
         echo "sivu1";
       }
       elseif($_GET["p"] == 3) {
         echo "sivu3";
       }
       ?>
     </section>
   <?php } ?>
  </div>
  <div class="sivupalkki"></div>
  </body>
</html>
