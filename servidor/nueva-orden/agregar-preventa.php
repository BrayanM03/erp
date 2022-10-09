<?php

    session_start();
    include '../database/conexion.php';    
    date_default_timezone_set("America/Matamoros");


    $id_producto = $_POST["id_product"];
    $cantidad = $_POST["cantidad"];
    $cliente = $_POST["cliente"];
    $tipo_descuento = $_POST["tipo_descuento"];
    $descuento_int = $_POST["descuento"];


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

    switch ($tipo_descuento) {
            case 'unidad':
            $descuento = $descuento_int;
            $porcentaje_descuento = (100/(floatval($data["precio_total"])/$descuento_int));
            $impuesto = $cantidad * ((floatval($data["precio_base"])-$impuesto)* floatval("0.".$data["tasa"]));

            break;

            case 'porcentaje':
                $descuento = ((floatval($descuento_int)/100) * floatval($data["precio_total"]));
                $porcentaje_descuento = $descuento_int;
                $impuesto = $cantidad * ((floatval($data["precio_base"]- $impuesto))* floatval("0.".$data["tasa"]));
            break;

            case null:
                $porcentaje_descuento = 0;
                $descuento =0;
                $impuesto = ($cantidad * floatval($data["impuesto"]));

            break;    
        
        default:
            $porcentaje_descuento = 0;
            $descuento =0;
            $impuesto = ($cantidad * floatval($data["impuesto"]));
            break;
    }


    $importe = ($cantidad * floatval($data["precio_total"])) - $descuento;
  

    $insert = "INSERT INTO carrito_compra(id,
                                          producto_id,
                                          cantidad,
                                          precio,
                                          porcentaje_descuento,
                                          descuento,
                                          impuesto,
                                          importe,
                                          cliente_id,
                                          usuario_id,
                                          descripcion) VALUES(null, ?,?,?,?,?,?,?,?,?,?)";
    $resp = $con->prepare($insert);
    $resp->execute([$id_producto, $cantidad, $data["precio_total"],$porcentaje_descuento, $descuento, $impuesto, $importe, $cliente, $_SESSION["id"],$data["descripcion"]]);
    $resp->closeCursor();
    $response = array("status"=> true, "mensj"=>"Los datos se insertaron correctamente", "data"=>$data);
    

    }else if($count > 0){

        $contar = "SELECT * FROM carrito_compra WHERE producto_id = ? AND usuario_id = ?";
        $re = $con->prepare($contar);
        $re->execute([$id_producto, $_SESSION["id"]]);

        while($row = $re->fetch(PDO::FETCH_OBJ)){
            $cantidad_actual = $row->cantidad;
            $importe_actual = $row->importe;
            $porcentaje_descuento_actual = $row->porcentaje_descuento;
            $descuento_actual = $row->descuento;
            $impuesto_actual = $row->impuesto;
            $id_detalle = $row->id;
        }

        switch ($tipo_descuento) {
            case 'unidad':
            $descuento = $descuento_int;
            $porcentaje_descuento = (100/(floatval($data["precio_total"])/$descuento_int));
            $impuesto = $cantidad * ((floatval($data["precio_base"]) - $descuento )* floatval("0.".$data["tasa"]));

            break;

            case 'porcentaje':
                $descuento = ((floatval($descuento_int)/100) * floatval($data["precio_total"]));
                $porcentaje_descuento = $descuento_int;
                $impuesto = $cantidad * ((floatval($data["precio_base"]-$impuesto))* floatval("0.".$data["tasa"]));
            break;

            case null:
                $porcentaje_descuento = 0;
                $descuento =0;
                $impuesto = ($cantidad * floatval($data["impuesto"]));

            break;    
        
        default:
            $porcentaje_descuento = 0;
            $descuento =0;
            $impuesto = ($cantidad * floatval($data["impuesto"]));
            break;
    }
        

        $nueva_cantidad = $cantidad + $cantidad_actual;
        $nuevo_impuesto = $impuesto + $nuevo_impuesto;
        $nuevo_porcentaje_descuento = $porcentaje_descuento_actual + $porcentaje_descuento;
        $nuevo_descuento = $descuento_actual + $descuento;
        $importe = ($cantidad * floatval($data["precio_total"])) - $descuento;

        $nuevo_importe = $importe_actual + $importe;

        $update = "UPDATE carrito_compra SET cantidad = ?, 
                                             porcentaje_descuento =?,
                                             descuento = ?,
                                             impuesto =?,
                                             importe = ? WHERE producto_id = ? AND usuario_id = ?";
        $re = $con->prepare($update);
        $re->execute([$nueva_cantidad, $nuevo_porcentaje_descuento, 
                     $nuevo_descuento, $nuevo_impuesto, $nuevo_importe, $id_producto, $_SESSION["id"]]);

       
        $response = array("status"=> true, "mensj"=>"Los datos se actualizarón correctamente");
    }


   

    /* $importe  = traerImporte($con);
        $response["importe"] = $importe;*/
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
 

?>     