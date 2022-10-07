<?php
  
  session_start();
  include '../database/conexion.php';
  
  date_default_timezone_set("America/Matamoros");
  $usuario_id = $_SESSION["id"];
  $response = array();

    $comprobar = "SELECT COUNT(*) FROM carrito_compra WHERE usuario_id = ?";
    $resp = $con->prepare($comprobar);
    $resp->execute([$usuario_id]);
    $total = $resp->fetchColumn();

    if($total > 0){
        $select = "SELECT * FROM carrito_compra WHERE usuario_id = ?";
        $resp = $con->prepare($select);
        $resp->execute([$usuario_id]);
        $importe =0;
        $iva =0;
        while ($row = $resp->fetch(PDO::FETCH_OBJ)) {
            //print_r($row['importe']);
            $importe = $importe + floatval($row->importe);
            $iva = $iva+ floatval($row->impuesto);

            //print_r($row);
            $response["data"][] = $row;
        }

        $response["importe"] = $importe;
        $response["iva"] = $iva;

        $response["status"] = true;
        $response["message"] = "El carrito tiene productos";
    }else{
        $response["data"] = [];
        $response["status"] = false;
        $response["message"] = "El carrito no tiene productos";
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);




?>