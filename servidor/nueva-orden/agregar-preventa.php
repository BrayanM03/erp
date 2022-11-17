<?php
 
    session_start();
    include '../database/conexion.php';    
    date_default_timezone_set("America/Matamoros");


    $id_producto = $_POST["id_product"];
    $cantidad = $_POST["cantidad"];
    $dato_precio = $_POST["dato_precios"];


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

          //Manejando datos sobre los precios
            if($dato_precio == "base"){
                $precio_base = $data['precio_base'];
                $impuesto = $data['impuesto'];
                $precio_total = $data['precio_total'];
            }else{
                $selct = "SELECT * FROM precios WHERE id = ?";
                $resx = $con->prepare($selct);
                $resx->execute([$dato_precio]);

                while ($row = $resx->fetch()) {
                    $precio_base = $row['precio_base'];
                    $impuesto = $row['impuesto'];
                    $precio_total = $row['precio_neto'];
                }
            }

      }


    $contar = "SELECT COUNT(*) FROM carrito_compra WHERE producto_id = ? AND usuario_id = ?";
    $re = $con->prepare($contar);
    $re->execute([$id_producto, $_SESSION["id"]]);
    $count = $re->fetchColumn();
    $re->closeCursor();

    if($count == 0){
  
    $importe_base = floatval($precio_base) * $cantidad;
    $impuesto = floatval($impuesto) * $cantidad;
    $importe =  floatval($precio_total) * $cantidad;

  //print_r($id_producto. "-- ".$cantidad. "-- ".$precio_base. "-- ".$importe_base. "-- ".$impuesto. "-- ".$importe. "-- ".$_SESSION["id"]. "--".$data["descripcion"]);

    $insert = "INSERT INTO carrito_compra(id,
                                          producto_id,
                                          cantidad,
                                          precio_unitario,
                                          importe_base,
                                          impuesto,
                                          importe,
                                          usuario_id,
                                          descripcion) VALUES(null, ?,?,?,?,?,?,?,?)";
    $resp = $con->prepare($insert);
    $resp->execute([$id_producto, $cantidad, $precio_base, $importe_base, $impuesto, $importe, $_SESSION["id"],$data["descripcion"]]);
    $resp->closeCursor();
    $response = array("status"=> true, "mensj"=>"Los datos se insertaron correctamente", "data"=>$_POST);
    

    }else if($count > 0){

        $contar = "SELECT * FROM carrito_compra WHERE producto_id = ? AND usuario_id = ?";
        $re = $con->prepare($contar);
        $re->execute([$id_producto, $_SESSION["id"]]);

        while($row = $re->fetch(PDO::FETCH_OBJ)){
            $id_detalle = $row->id;
            $cantidad_actual = $row->cantidad;
            $importe_base_actual = $row->importe_base;
            $impuesto_actual = $row->impuesto;
            $importe_actual = $row->importe;
        }

        

        $nueva_cantidad = $cantidad + $cantidad_actual;
        $nuevo_importe_base = floatval($precio_base) * $nueva_cantidad;
        $nuevo_importe =  floatval($precio_total) * $nueva_cantidad;
        $nuevo_impuesto = floatval($impuesto) * $nueva_cantidad;
    

        $update = "UPDATE carrito_compra SET cantidad = ?,
                                             importe_base = ?, 
                                             impuesto =?,
                                             importe = ? WHERE producto_id = ? AND usuario_id = ?";
        $re = $con->prepare($update);
        $re->execute([$nueva_cantidad, $nuevo_importe_base, $nuevo_impuesto, $nuevo_importe, $id_producto, $_SESSION["id"]]);

       
        $response = array("status"=> true, "mensj"=>"Los datos se actualizarón correctamente");
    }


   

    /* $importe  = traerImporte($con);
        $response["importe"] = $importe;*/
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
 

?>     