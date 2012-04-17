<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include_once("viestifunktiot.php");
        include_once 'kategoriafunktiot.php';
        $nakyvyys = getNakyvyys("admin");
        var_dump($nakyvyys);
       
        ?>
    </body>
</html>
