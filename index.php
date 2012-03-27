<?php
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Testi</title>
    <style>
      table  {border: solid thin black}
      tr {
        text-align: center;
      }
    </style>
  </head>
  <body>
 
   <?php
     if(!session_is_registered("käyttäjänimi")){
   ?>
   <section>
    <h1>Kirjaudu sisään!</h1>
    <form action="login.php" method="post">
      <input type="text" name="käyttäjänimi" required placeholder="Käyttäjätunnus" /><br/>
      <input type="password" name="salasana" required placeholder="Salasana" /><br/><br/>
      <input type="submit" value="Kirjaudu!" />
    </form>
   </section>
   <?php }
    else {
      echo "<section>";
      echo "<h1>Tekstipalsta: </h1>";
      echo "<p>Kirjautuneena käyttäjänä " . $_SESSION["käyttäjänimi"] . ", Ylläpito-oikeus: " . $_SESSION["admin"] . "</p>";
      echo '<a href="/admin/admin.php?p=1">Ylläpito</a>';
      include("tulostus.php");
      tulosta();
    ?>
     <form action="laheta.php" method="post">
       <input type="text" name="otsikko" placeholder="Otsikko" /><br />            
       <input type="text" name="teksti" placeholder="Teksti" /><br />
       <input type="hidden" name="kategoria" value="2" /><br />
       <input type="submit" value="Lähetä" />
     </form>
     <p><a href="logout.php">Kirjaudu ulos!</a></p>
    <?php } ?>
  </section>
  </body>
</html>
