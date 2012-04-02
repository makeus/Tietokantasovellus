<?php
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    
    <title>Työryhmätiedoitus</title>
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
Käyttäjänimi	<input type="text" name="käyttäjänimi" autofocus required />
Salasana 		<input type="password" name="salasana" required />
<input type="submit" id="kirjaudusubmit" value="Kirjaudu!" /></pre>
       </form>
     </section>

     <?php }
     else {?>
     <nav>
       <a href="/" <?php if((!isset($_GET["p"])) or ($_GET["p"] == 1)){echo "id=\"nykyne\"";}?>>Etusivu</a>
       <a href="/?p=2" <?php if($_GET["p"] == 2){echo "id=\"nykyne\"";}?>>Kirjoita viesti</a>
       <?php if($_SESSION["admin"] == 't'){echo "<a href=\"admin/admin.php?p=1\">Ylläpito</a>\n";}?>
       <a href="logout.php"> Kirjaudu ulos </a>
     </nav>
     <section>
       <div id="välipalkki">
          <p class="väliteksti">Kirjautuneena käyttäjänä <?php echo $_SESSION["käyttäjänimi"]; ?></p>
          <p class="väliteksti"><?php echo date("d.m.y H:i:s", $_SERVER['REQUEST_TIME']); ?></p>
       </div>
       <?php
       if((!isset($_GET["p"])) or ($_GET["p"] == 1)){
         include("tulostaKategoriat.php");
       }
       elseif($_GET["p"] == 2){
         include("kirjoitaViesti.php");
       }
       elseif($_GET["p"] == 3) {
         // Tähä kaiketi viestin tulostus
       }
       ?>
     </section>
   <?php } ?>
  </div>
  <div class="sivupalkki"></div>
  </body>
</html>
