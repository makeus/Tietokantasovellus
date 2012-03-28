<?php
  session_start(); 
  if($_SESSION["admin"] == 't'){  // Jos admin oikeudet on t, eli true!
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Ylläpitosivu</title>
    <style>
      body, html {
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        font-family: "Verdana", "Arial", serif;
      }
      div {
        height: 88%;
        border-top: thin solid black;
        display: -moz-box;
        display: -webkit-box;
        display: box;
        -moz-box-orient: horizontal;
        -webkit-box-orient: horizontal;
        box-orient: horizontal;
      }
      h1 {
        margin-top: 0;
        padding-top: 15px;
        padding-left: 10px;
        color: lightgrey;
        font-size: 50px;

      }
      section > h1 {
        font-size:20px;
        color: slategrey;
      }
      nav {
        padding: 20px;
        padding-top: 40px;
        padding-right: 25px;
        border-right: thin solid black;
        float: center;
      }
      ul, menu, dir {
        margin-top: 0px;
        padding-left: 10px;
        list-style: none;
      }
      li > a {   
        text-decoration: none;
        font-size: 15px;
	color: slategrey;
        line-height: 180%;
      }
      nav > h2 {        
        color: lightslategrey;
        font-size: 17px;
        margin-bottom: 6px;
      }
      section {
        -moz-box-flex: 1;
        -webkit-box-flex: 1;
        box-flex: 1;
        padding: 2em;
      }
      #nykyne {
         color: black;
      }
      table  {
         width: 100%;
         border: solid thin black
      }
      tr {
        text-align: center;
      }
    </style>
    <script type="text/javascript">
      function varmista(url){
        console.log(url);
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
         include("admintulosta.php");
         tulostaRyhmat();
       }
       if($_GET["p"] == 2){
         echo "<h1>Luo ryhmä</h1>";
       }
       if($_GET["p"] == 3){
         echo "<h1>Hallinnoi käyttäjiä</h1>";
       }
       if($_GET["p"] == 4){
         echo "<h1>Luo käyttäjä</h1>";
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
