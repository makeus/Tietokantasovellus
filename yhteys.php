<?php
    try {
       $yhteys = new PDO("pgsql:host=localhost;dbname=keus", "keus", "a646a8dd503014f5"); 
    } catch (PDOException $e) {
       die("VIRHE: " . $e->getMessage());
    }
    $yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
