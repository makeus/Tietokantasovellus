<!DOCTYPE html>
<html>
  <head>
    <title>Testi</title>
  </head>
  <body>
    <?php
      include("tulostus.php");
      tulosta();
    ?>
    <form action="laheta.php" method="post">
      <input type="text" name="viesti" />
      <input type="submit" value="Lähetä" />
    </form>
  </body>
</html>
