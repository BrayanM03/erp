<?php

    session_start();
    include '../database/conexion.php';    
    date_default_timezone_set("America/Matamoros");


    $id_producto = $_POST["id_product"];
    $cantidad = $_POST["cantidad"];
    $cliente = $_POST["cliente"];

    $validar = "SELECT COUNT(*) FROM inventario WHERE id = ?";
    $re = $con->prepare($validar);
    $re->execute([$id_producto]);
    $total_p = $re->fetchColumn();
    $re->closeCursor();

    if($total_p > 0){
        $sel = "SELECT * FROM inventario WHERE id = ?";
        $res = $con->prepare($sel);
        $res->execute([$id_producto]);

        while ($row = $res->fetch()) {
             $data = $row;
        }

      }


    $contar = "SELECT COUNT(*) FROM carrito_compra WHERE producto_id = ? AND usuario_id = ?";
    $re = $con->prepare($contar);
    $re->execute([$id_producto, $_SESSION["id"]]);
    $count = $re->fetchColumn();
    $re->closeCursor();

    if($count == 0){


    $importe = $cantidad * floatval($data["precio_total"]);
    $impuesto = $cantidad * floatval($data["impuesto"]);

    $insert = "INSERT INTO carrito_compra(id,
                                          producto_id,
                                          cantidad,
                                          precio,
                                          impuesto,
                                          importe,
                                          cliente_id,
                                          usuario_id,
                                          descripcion) VALUES(null, ?,?,?,?,?,?,?,?)";
    $resp = $con->prepare($insert);
    $resp->execute([$id_producto, $cantidad, $data["precio_total"],$impuesto, $importe, $cliente, $_SESSION["id"],$data["descripcion"]]);
    $resp->closeCursor();
    $response = array("status"=> true, "mensj"=>"Los datos se insertaron correctamente", "data"=>$data);
    

    }else if($count > 0){

        $contar = "SELECT * FROM carrito_compra WHERE producto_id = ? AND usuario_id = ?";
        $re = $con->prepare($contar);
        $re->execute([$id_producto, $_SESSION["id"]]);

        while($row = $re->fetch(PDO::FETCH_OBJ)){
            $cantidad_actual = $row->cantidad;
            $id_detalle = $row->id;
        }
        

        $nueva_cantidad = $cantidad + $cantidad_actual;
        $nuevo_importe = $nueva_cantidad * $data["precio_total"];

        $update = "UPDATE carrito_compra SET cantidad = ?, importe = ? WHERE producto_id = ? AND usuario_id = ?";
        $re = $con->prepare($update);
        $re->execute([$nueva_cantidad, $nuevo_importe, $id_producto, $_SESSION["id"]]);

       
        $response = array("status"=> true, "mensj"=>"Los datos se actualizarón correctamente");
    }


   

    /* $importe  = traerImporte($con);
        $response["importe"] = $importe;*/
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
 

?>     