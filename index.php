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
      echo "<p>Kirjautuneena käyttäjänä " . $_SESSION["käyttäjänimi"] . "</p>";
      include("tulostus.php");
      tulosta();
      echo "</section>";
    } ?>
  </body>
</html>
