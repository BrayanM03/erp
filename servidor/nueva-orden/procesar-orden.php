<?php
  
    session_start();
    include '../database/conexion.php';
    
    date_default_timezone_set("America/Matamoros");
    $usuario_id = $_SESSION["id"]; 

    //Se cuenta el detalle de preventa para insertarlo en el detalle de ordenes
    $contar = "SELECT COUNT(*) FROM carrito_compra WHERE usuario_id = ?";
    $re = $con->prepare($contar);
    $re->execute([$usuario_id]);
    $count = $re->fetchColumn();


    if($count > 0) {

    $hora = date('h:i:s a');
    $fecha= date('Y-m-d');
    $id_cliente = $_POST['cliente'];
    $estatus = "Realizada";

    //Insertando en tabla ordenes
    $insertar = "INSERT INTO ordenes(id, 
                                     cliente_id, 
                                     fecha,
                                     hora,
                                     estatus,
                                     usuario_id) VALUES(null, ?,?,?,?,?)";


    $re = $con->prepare($insertar);
    $re->execute([$id_cliente, $fecha, $hora, $estatus, $usuario_id]);

    //Se finaliza la insercion de la orden

    //Obtener ultimo id
    $id_orden = $con->lastInsertId();
    

        $response = array("status"=> true, "mensj"=>"Venta generada con exito", "id_orden"=>$id_orden);

        $consultar = "SELECT * FROM carrito_compra WHERE usuario_id = ?";
        $resp = $con->prepare($consultar);
        $resp->execute([$usuario_id]);

        $utilidad = 0;
        $suma_utilidad = 0;
        while ($row = $resp->fetch()) {

            //En cada iteracion insertamos la partida en el detalle de orden
            $productos[] = $row;

            $response["partidas"] = $productos;
            //Obtenemos la utilidad de cada partida
            
                
                $utilidad = "SELECT costo FROM inventario WHERE id = ?";
                $re = $con->prepare($utilidad);
                $re->execute([ $row['producto_id']]);
                $costo_producto = $re->fetchColumn();
    
                //Operacion con las ganancias
                $utilidad_x_partida = $row['precio_unitario'] - $costo_producto; 
                $utilidad_neta = $utilidad_x_partida * $row["cantidad"];
                $suma_utilidad += $suma_utilidad + $utilidad_neta;

                //Traer stock
                    $consult = "SELECT stock FROM inventario WHERE id = ?";
                    $rep = $con->prepare($consult);
                    $rep->execute([$row['producto_id']]);
                    $stock_actual = $rep->fetchColumn();
                    $rep->closeCursor();

                    $stock_nuevo = $stock_actual - $row["cantidad"];

                //Actualizando el stock
                $update_stock = "UPDATE inventario SET stock = ? WHERE id =?";
                $respuesta = $con->prepare($update_stock);
                $respuesta->execute([$stock_nuevo, $row['producto_id']]);


                

            //Insertando los datos

            $insertar = "INSERT INTO detalle_orden(id, 
                                                   descripcion, 
                                                   cantidad,
                                                   precio_unitario,
                                                   importe,
                                                   utilidad,
                                                   producto_id,
                                                   user_id,
                                                   orden_id)
                                                   VALUES (null, ?,?,?,?,?,?,?,?)";


            $re = $con->prepare($insertar);
            $re->execute([$row["descripcion"], $row["cantidad"], $row["precio_unitario"], 
            $row["importe"], $utilidad_neta, $row["producto_id"], $row["user_id"], $id_orden]);

        }

        $updt = "UPDATE ordenes SET utilidad = ? WHERE id =?";
        $res = $con->prepare($updt);
        $res->execute([$suma_utilidad, $id_orden]);

    }else {
        $response = array("status"=> false, "mensj"=>"Agrega articulos a la tabla");
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>