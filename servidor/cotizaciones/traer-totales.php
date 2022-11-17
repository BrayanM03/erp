<?php
session_start();
  include "../database/conexion.php";
  date_default_timezone_set('America/Matamoros');
  $usuario_id = $_SESSION["id"];
  $tasa = $_POST["tasa"];

    $contar = "SELECT COUNT(*) FROM detalle_cotizacion_tmp WHERE usuario_id = ?";
    $res = $con->prepare($contar);
    $res->execute([$usuario_id]);
    $total = $res->fetchColumn();
    $res->closeCursor();

    if($total > 0)
{
    $sel = "SELECT * FROM detalle_cotizacion_tmp WHERE usuario_id = ?";
    $resp = $con->prepare($sel);
    $resp->execute([$usuario_id]);

    $suma_importe = 0;
    $suma_descuento = 0;
    while($fila = $resp->fetch()){
        /* $id = $fila["id"];
        $codigo = $fila["codigo"];
        $concepto = $fila["concepto"];
        $producto_id = $fila["producto_id"];
        $cantidad = $fila["cantidad"];
        $precio_unit = $fila["precio_unit"];
        $importe = $fila["importe"];
        $usuario_id = $fila["usuario_id"]; */
        $suma_importe += floatval($fila["importe"]);
        $suma_descuento += floatval($fila["descuento"]);
    }

    $resp->closeCursor();
    
    $response = [];
    $response["subtotal"] = $suma_importe;
    $response["descuento"] = $suma_descuento;
    $impuesto = round($suma_importe * floatval($tasa),2);
    $response["tasa"] = floatval($tasa);
    $total_neto = $suma_importe + $impuesto;
    $response["impuesto"] = $impuesto;
    $response["neto"] = round($total_neto,2);

    
    

    
}else{
    $response["descuento"] = 0;
    $response["subtotal"] = 0;
    $response["tasa"] = floatval($tasa);
    $response["impuesto"] = 0;
    $response["neto"] = 0;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>