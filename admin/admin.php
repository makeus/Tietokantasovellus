<?php
  session_start(); 
  if($_SESSION["käyttäjänimi"] == 'admin'){
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
        height: 80%;
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
      nav {
        padding: 15px;
        padding-right: 25px;
        height: 100%;
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
        font-size: 16px;
	color: slategrey;
        line-height: 180%;
      }
      nav > h2 {        
        color: lightslategrey;
        font-size: 18px;
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

    </style>
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
        <li><a href="admin.php?p=4" <?php if($_GET["p"] == 4){ echo'id="nykyne"';} ?>>Luo käyttäjiä</a></li>
      <ul>
    </nav>      
    <section>
     <?php
       if($_GET["p"] == 1){
         include("admintulosta.php");
         tulostaRyhmat();
       }
       if($_GET["p"] == 2){
     ?>
     Sivu2
     <?php }
       if($_GET["p"] == 3){
     ?>
     Sivu3
     <?php }
       if($_GET["p"] == 4){
     ?>
     Sivu4
     <?php } ?>
    </section>
    </div>
  </body>
</html>

<?php } 
  else { 
    header('HTTP/1.1 403 Forbidden');
  }
?>
