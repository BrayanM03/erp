<?php
if ($_POST) {
    session_start();
    include "../database/conexion.php";
    date_default_timezone_set('America/Matamoros');

    $costo = $_POST["costo"];
    $precio_base = $_POST["precio_base"];
    $tasa = $_POST["tasa"];
    $precio_neto = $_POST["neto"];
    $producto_id = $_POST["producto_id"];
    $usuario_id = $_SESSION["id"];
    $etiqueta = $_POST["etiqueta"];
    $impuesto = ((floatval($precio_base))* floatval("0.".$tasa));



    $insercion = "INSERT INTO precios_tmp(id, 
                                         costo,
                                         precio_base,
                                         tasa,
                                         impuesto,
                                         precio_neto,
                                         etiqueta,
                                         usuario_id) VALUES(null,?,?,?,?,?,?,?)";
    $resp = $con->prepare($insercion);
   
    $resp->execute([$costo, $precio_base, $tasa, $impuesto, $precio_neto, $etiqueta, $usuario_id]);

    $resp->closeCursor();

    $last_id = $con->lastInsertId();

   
    $response = array("status"=>true, "message"=> "Precio agregado correctamente", "id"=>$last_id);
    echo json_encode($response, JSON_UNESCAPED_UNICODE);

}



?>