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
    $id_producto = $_POST["id_producto"];



    $insercion = "INSERT INTO precios(id, 
                                         costo,
                                         precio_base,
                                         tasa,
                                         impuesto,
                                         precio_neto,
                                         etiqueta,
                                         producto_id,
                                         usuario_id) VALUES(null,?,?,?,?,?,?,?,?)";
    $resp = $con->prepare($insercion);
   
    $resp->execute([$costo, $precio_base, $tasa, $impuesto, $precio_neto, $etiqueta, $id_producto, $usuario_id]);

    $resp->closeCursor();

    $last_id = $con->lastInsertId();

   
    $response = array("status"=>true, "message"=> "Precio agregado correctamente", "id"=>$id_producto);
    echo json_encode($response, JSON_UNESCAPED_UNICODE);

}



?>