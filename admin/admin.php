<?php
  session_start(); 
  if($_SESSION["admin"] == 't'){  // Jos admin oikeudet on t, eli true!
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Ylläpitosivu</title>
    <LINK rel="stylesheet" type="text/css" href="admin.css"/>
    <script type="text/javascript">
      function varmista(url){
        console.log(url);text-align: center;
        if(confirm("Oletko varma, että haluat poistaa ryhmän? Poistaminen poistaa myös kategorian, viestit..")) {
          window.location = url;
        }
      }
    </script>
  </head>
  <body>
    <h1>Ylläpitosivu</h1>
    <div>
    <nav>
      <h2>Käyttäjät</h2>
      <ul>
        <li><a href="admin.php?p=1" <?php if($_GET["p"] == 1){ echo'id="nykyne"';} ?>>Hallinnoi ryhmiä</a></li>
        <li><a href="admin.php?p=2" <?php if($_GET["p"] == 2){ echo'id="nykyne"';} ?>>Luo ryhmä</a></li>
      </ul>
      <h2>Ryhmät</h2>
      <ul>
        <li><a href="admin.php?p=3" <?php if($_GET["p"] == 3){ echo'id="nykyne"';} ?>>Hallinnoi käyttäjiä</a></li>
        <li><a href="admin.php?p=4" <?php if($_GET["p"] == 4){ echo'id="nykyne"';} ?>>Luo käyttäjä</a></li>
      </ul>
      <h2>Kategoriat</h2>
      <ul>
        <li><a href="admin.php?p=5" <?php if($_GET["p"] == 5){ echo'id="nykyne"';} ?>>Hallinnoi kategorioita</a></li>
        <li><a href="admin.php?p=6" <?php if($_GET["p"] == 6){ echo'id="nykyne"';} ?>>Luo kategoria</a></li>
      </ul><br/>
      <ul>
       <li><a href="../logout.php">Logout</a></li>
       <li><a href="../index.php">Etusivu</a></li>
      </ul>
    </nav>      
    <section>
     <?php
       if($_GET["p"] == 1){
         echo "<h1>Hallinnoi ryhmiä</h1>";
         include("ryhmatulosta.php");
         tulostaRyhmat();
         if(isset($_GET["m"])){
           muokkaaRyhma($_GET["m"]);
         }
       }
       if($_GET["p"] == 2){
         echo "<h1>Luo ryhmä</h1>";
       }
       if($_GET["p"] == 3){
         echo "<h1>Hallinnoi käyttäjiä</h1>";
         include("poistakayttaja.php");
         if(isset($_GET["m"])){
           tulostaSamankaltaiset($_GET["m"]);
         }
       }
       if($_GET["p"] == 4){
         echo "<h1>Luo käyttäjä</h1>";
         include("lisaakayttaja.php");
       }
       if($_GET["p"] == 5){
         echo "<h1>Hallinnoi kategorioita</h1>";
       }
       if($_GET["p"] == 6){
         echo "<h1>Luo kategoria</h1>";
       }
     ?>
    </section>
    </div>
  </body>
</html>

<?php } 
  else { 
    header('HTTP/1.1 403 Forbidden');
  }
?>
