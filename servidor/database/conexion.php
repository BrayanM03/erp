<?php
$usuario = "root";
$pass = "root";
try {
    $con = new PDO('mysql:host=localhost:8889;dbname=erp', $usuario, $pass);
   
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>